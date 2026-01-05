<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Course;
use App\Models\Coupon;
use App\Models\Purchase;
use App\Models\PurchaseInstallment;
use App\Models\PurchasePayment;
use App\Models\User;
use Carbon\Carbon;
use Google\Service\Adsense\Payment;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class AdmissionController extends Controller
{


  public function index(Request $request)
  {
    $query = Purchase::with([
      'student:id,name,email,mobile',
      'course:id,title',
      'payments'
    ]);

    /* ================= FILTERS ================= */

    // Status filter
    if ($request->filled('type')) {
      if ($request->type !== 'all') {
        $query->where('status', $request->type);
      }
    }

    // Search (name / email / mobile)
    if ($request->filled('search')) {
      $query->whereHas('student', function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('email', 'like', "%{$request->search}%")
          ->orWhere('mobile', 'like', "%{$request->search}%");
      });
    }

    // Date filter
    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    $transactions = $query->latest()->paginate(15);

    /* ================= CARDS DATA ================= */

    $stats = [
      'total'    => $this->statsByStatus(),
      'paid'     => $this->statsByStatus('paid'),
      'pending'  => $this->statsByStatus('pending'),
      'rejected' => $this->statsByStatus('rejected'),
    ];

    return view('company.academic.admissions.index', compact(
      'transactions',
      'stats'
    ));
  }

  private function statsByStatus($status = null)
  {
    $q = Purchase::query();
    if ($status) $q->where('status', $status);

    return [
      'count'   => $q->count(),
      'online'  => (clone $q)->where('payment_method', 'online')->count(),
      'manual'  => (clone $q)->whereIn('payment_method', ['bank', 'manual'])->count(),
      'cash'    => (clone $q)->where('payment_method', 'cash')->count(),
    ];
  }

  public function downloadInvoice($id)
  {
    $purchase = Purchase::with('student', 'course')->findOrFail($id);

    abort_if($purchase->status !== 'paid', 403);

    return PDF::loadView('company.academic.payments.purchase-invoice', compact('purchase'))
      ->download("Invoice-{$purchase->payments->order_id}.pdf");
  }

  public function reject(Request $request)
  {
    $request->validate([
      'purchase_id' => 'required|exists:purchases,id',
      'notes'       => 'required|string'
    ]);

    $purchase = Purchase::findOrFail($request->purchase_id);

    $purchase->update([
      'status' => 'rejected',
      'notes'  => $request->notes
    ]);

    return back()->with('success', 'Transaction rejected');
  }





  public function create(Request $request)
  {
    // for create/edit form you may pass $purchase for edit; here create
    return view('company.academic.admissions.form');
  }

  // AJAX search students
  public function studentSearch(Request $req)
  {
    $q = $req->get('q', '');
    $data = User::where('name', 'like', "%{$q}%")
      ->orWhere('email', 'like', "%{$q}%")
      ->orWhere('mobile', 'like', "%{$q}%")
      ->limit(30)->get(['id', 'name', 'email', 'mobile']);
    return response()->json($data);
  }

  // AJAX course search
  public function courseSearch(Request $req)
  {
    $q = $req->get('q', '');
    // ['id', 'title', 'net_price', 'actual_price', 'total_hours', 'started_at', 'ended_at', 'coupon_available', 'allow_installment', 'description', 'is_tax'])
    $data = Course::where('title', 'like', "%{$q}%")->limit(30)->get();
    return response()->json($data);
  }

  public function courseInfo($id)
  {
    $course = Course::findOrFail($id);
    return response()->json($course);
  }

  public function validateCoupon(Request $req)
  {
    $studentId = $req->student_id;
    $courseId  = $req->course_id;
    $course    = Course::where('id', $courseId)->first();
    $subtotal  = $course->net_price;
    $code      = $req->code ?? $req->coupon_code;

    if (!$studentId || !$courseId) {
      return response()->json(['ok' => false, 'message' => 'Missing required fields']);
    }

    $now = now();

    // Load coupon with course relation
    $coupon = Coupon::with('courses')
      ->where('offer_code', $code)
      ->where('is_active', 1)
      ->first();

    if (!$coupon) {
      return response()->json(['ok' => false, 'message' => 'Invalid coupon']);
    }

    //---------------------------
    // 1) VALIDATE COURSE APPLICABILITY
    //---------------------------

    // coupon_selection_type = all_courses / selected_courses
    if ($coupon->coupon_selection_type === 'selected_courses') {
      $allowedCourses = $coupon->coupon_course->pluck('course_id')->toArray();

      if (!in_array($courseId, $allowedCourses)) {
        return response()->json(['ok' => false, 'message' => 'This coupon is not valid for the selected course']);
      }
    }

    //---------------------------
    // 2) VALIDATE DATE RANGE
    //---------------------------

    // start_date_time
    if ($coupon->start_date_time && $coupon->start_date_time > $now) {
      return response()->json(['ok' => false, 'message' => 'Coupon is not active yet']);
    }

    // end_date_time (apply only if NOT unlimited)
    if ($coupon->is_unlimited != 1) {
      if ($coupon->end_date_time && $coupon->end_date_time < $now) {
        return response()->json(['ok' => false, 'message' => 'Coupon has expired']);
      }
    }

    //---------------------------
    // 3) VALIDATE MIN ORDER VALUE
    //---------------------------

    if ($coupon->minimum_order_value && $subtotal < $coupon->minimum_order_value) {
      return response()->json(['ok' => false, 'message' => 'Order value is too low for this coupon']);
    }

    //---------------------------
    // 4) VALIDATE STUDENT USAGE LIMIT
    //---------------------------

    // max_usage_per_student = null means unlimited
    if ($coupon->max_usage_per_student !== null) {

      $usageCount = Purchase::where('student_id', $studentId)
        ->where('coupon_code', $code)
        ->where('status', 'paid')
        ->count();

      if ($usageCount >= $coupon->max_usage_per_student) {
        return response()->json(['ok' => false, 'message' => 'You already used this coupon maximum times']);
      }
    }

    // 5) VALIDATE GLOBAL USAGE LIMIT
    if ($coupon->max_usage_count !== null) {
      if ($coupon->current_usage_count >= $coupon->max_usage_count) {
        return response()->json([
          'ok' => false,
          'message' => 'Coupon usage limit reached'
        ]);
      }
    }


    //---------------------------
    // 6) CALCULATE DISCOUNT
    //---------------------------

    $discount = 0;

    if ($coupon->discount_type === 'percentage') {
      $discount = round(($subtotal * $coupon->discount_value) / 100, 2);

      // Optional: cap discount if coupon has max discount limit
      if ($coupon->max_discount_amount) {
        $discount = min($discount, $coupon->max_discount_amount);
      }
    } elseif ($coupon->discount_type === 'flat') {
      $discount = $coupon->discount_value;
    }

    //---------------------------
    // 7) PASS RESPONSE
    //---------------------------

    return response()->json([
      'ok'              => true,
      'discount_amount' => $discount,
      'coupon'          => $coupon
    ]);
  }


  // store purchase (save pending and redirect to PhonePe)
  public function admissionStore(Request $req)
  {

    $req->validate([
      'student_id' => 'required|exists:users,id',
      'course_id' => 'required|exists:courses,id',
      'coupon_code' => 'nullable',
      'payment_method' => 'required',
      'discount_amount' => 'nullable|numeric|min:0',
      'tax_percent' => 'nullable|numeric|min:0',
      'is_installment' => 'nullable|boolean',
      'installments' => 'nullable|array',
      'notes' => 'nullable',
    ]);


    $purchaseDetails   = $this->calculatePurchaseDetails($req);

    //check installment_grand_total == grand_total;


    if ($req->has('is_installment')) {
      if ($purchaseDetails['installment']['installment_grand_total'] != $purchaseDetails['grand_total']) {
        return redirect()
          ->back()
          ->with('error', 'Installment Amount and Grand Total doesnot match please check');
      }
    }


    DB::beginTransaction();
    try {
      $purchase = Purchase::create([
        'student_id' => $req->student_id,
        'course_id' => $req->course_id,
        'coupon_code' => $purchaseDetails['coupon_code'] ?? null,
        'price' => $purchaseDetails['course_price'],
        'discount_amount' => $purchaseDetails['discount_amount'] ?? 0,
        'tax_percent' => $purchaseDetails['tax']['tax_percent'] ?? 0,
        'tax_amount' => $purchaseDetails['tax']['tax_amount'],
        'is_installment' => $req->is_installment == 1 ? 1 : 0,
        'installments_count' => $purchaseDetails['installment']['installments_count'],
        'installment_interval_months' => $purchaseDetails['installment']['installment_interval_months'] ?? 0,
        'installment_additional_amount' => $purchaseDetails['installment']['additional_amount'] ?? 0,
        'notes' => $req->notes ?? null,
        'status' => 'pending', // initial pending
        'created_by' => auth()->user()->id,
        'tax_included' => $purchaseDetails['course']['tax_included'] == 'included' ? 1 : 0,
        'grand_total' => $purchaseDetails['grand_total'],
        'payment_method' => $req->payment_method,
        'payment_source' => 'web',
      ]);

      $firstPayment = null;
      // installments creation (if provided)
      if ($req->has('is_installment')) {
        foreach ($req->installments as $ins) {
          PurchaseInstallment::create([
            'purchase_id' => $purchase->id,
            'due_date' => $ins['date'] ?? null,
            'amount' => $ins['amount'] ?? 0,
            'paid_amount' => 0,
            'is_paid' => false,
          ]);
        }
        $firstPayment =  $req->installments[0]['amount'];
      }

      // create payment record (initiated)
      $orderId = $this->invoiceNumberGenerate();
      $payment = PurchasePayment::create([
        'purchase_id' => $purchase->id,
        'gateway' => $req->payment_method,
        'order_id' => $orderId,
        'amount' => $purchase->is_installment ? $firstPayment ?? 0 : $purchase->grand_total ?? 0,
        'currency' => 'INR',
        'status' => 'initiated',
      ]);

      DB::commit();

      return $this->redirectToPaymentGateway($purchase, $payment);
    } catch (\Throwable $ex) {
      DB::rollBack();
      return back()->withErrors(['error' => $ex->getMessage()]);
    }
  }

  function invoiceNumberGenerate()
  {
    $ordercount = Purchase::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
    return 'ORDRBMT' . date('ymd') . sprintf('%04d', $ordercount + 1);
  }

  protected function redirectToPaymentGateway(Purchase $purchase, PurchasePayment $payment)
  {
    switch ($payment->gateway) {

      case 'online':
        return redirect()->route('company.payments.init', $payment->order_id);
      case 'manually':
        return redirect()->route('company.payments.bank-details', $purchase->id);
      case 'in-cash':
        $purchase->update(['status' => 'paid']);
        $payment->update(['status' => 'success']);

        return redirect()
          ->route('company.admissions.success', $purchase->id)
          ->with('success', 'Cash payment marked as paid');

      case 'free':
        $purchase->update(['status' => 'paid']);
        $payment->update(['status' => 'success']);

        return redirect()
          ->route('company.admissions.success', $purchase->id);

      default:
        throw new \Exception('Invalid payment method');
    }
  }



  public function calculatePurchaseDetails(Request $request)
  {
    $course = Course::findOrFail($request->course_id);

    // Base price
    $price = $course->net_price;

    // Coupon
    $couponData = $this->validateCouponData($request, $course);

    $discount = $couponData['discount_amount'];
    $afterDiscount = max($price - $discount, 0);

    // Installment
    $installmentData = $request->is_installment
      ? $this->installmentCalculate($request)
      : [];


    $installmentExtra = $installmentData['additional_amount'] ?? 0;

    // Tax
    $taxData = $this->taxCalculate($request, $course, $afterDiscount + $installmentExtra);

    // Grand total
    $grandTotal = round(
      $afterDiscount + $installmentExtra + $taxData['tax_amount'],
      2
    );

    return [
      'course'           => $course,
      'course_price'     => $price,
      'discount_amount'  => $discount,
      'after_discount'   => $afterDiscount,
      'installment'      => $installmentData,
      'tax'              => $taxData,
      'grand_total'      => $grandTotal,
      'coupon_code'      => $couponData['coupon']['offer_code'] ?? null,
    ];
  }



  public function installmentCalculate(Request $request)
  {
    $data['installments_count'] = 0;
    $data['installment_interval_months'] = 0;
    $data['additional_amount'] = 0;
    $data['installment_grand_total'] = 0;
    $data['installments'] = [];

    if (isset($request->is_installment) && $request->installments_count > 0) {
      $installmentTotal = 0;
      foreach ($request->installments ?? [] as $installment) {
        $installmentTotal += $installment['amount'] ?? 0;
      }

      $data['installments_count']          =  $request->installments_count;
      $data['installment_interval_months'] =  $request->installment_interval_months;
      $data['additional_amount']           =  $request->installment_additional_amount;
      $data['installment_grand_total']     =  number_format($installmentTotal, 2);
      $data['installments']                =  $request->installments;

      return $data;
    } else {
      return $data;
    }
  }




  public function validateCouponData(Request $req)
  {
    $studentId = $req->student_id;
    $courseId  = $req->course_id;
    $course    = Course::where('id', $courseId)->first();
    $subtotal  = $course->net_price;
    $code      = $req->code ?? $req->coupon_code;




    $data['discount_amount'] = 0;
    $data['coupon']          = 0;


    if (!$studentId || !$courseId) {
      return $data;
    }

    $now = now();

    // Load coupon with course relation
    $coupon = Coupon::with('courses')
      ->where('offer_code', $code)
      ->where('is_active', 1)
      ->first();

    if (!$coupon) {
      return $data;
    }

    //---------------------------
    // 1) VALIDATE COURSE APPLICABILITY
    //---------------------------

    // coupon_selection_type = all_courses / selected_courses
    if ($coupon->coupon_selection_type === 'selected_courses') {
      $allowedCourses = $coupon->coupon_course->pluck('course_id')->toArray();

      if (!in_array($courseId, $allowedCourses)) {
        return $data;
      }
    }

    //---------------------------
    // 2) VALIDATE DATE RANGE
    //---------------------------

    // start_date_time
    if ($coupon->start_date_time && $coupon->start_date_time > $now) {
      return $data;
    }

    // end_date_time (apply only if NOT unlimited)
    if ($coupon->is_unlimited != 1) {
      if ($coupon->end_date_time && $coupon->end_date_time < $now) {
        return $data;
      }
    }

    //---------------------------
    // 3) VALIDATE MIN ORDER VALUE
    //---------------------------

    if ($coupon->minimum_order_value && $subtotal < $coupon->minimum_order_value) {
      return $data;
    }

    //---------------------------
    // 4) VALIDATE STUDENT USAGE LIMIT
    //---------------------------

    // max_usage_per_student = null means unlimited
    if ($coupon->max_usage_per_student !== null) {

      $usageCount = Purchase::where('student_id', $studentId)
        ->where('coupon_code', $code)
        ->where('status', 'paid')
        ->count();

      if ($usageCount >= $coupon->max_usage_per_student) {
        return $data;
      }
    }

    // 5) VALIDATE GLOBAL USAGE LIMIT
    if ($coupon->max_usage_count !== null) {
      if ($coupon->current_usage_count >= $coupon->max_usage_count) {
        return $data;
      }
    }


    //---------------------------
    // 6) CALCULATE DISCOUNT
    //---------------------------

    $discount = 0;

    if ($coupon->discount_type === 'percentage') {
      $discount = round(($subtotal * $coupon->discount_value) / 100, 2);

      // Optional: cap discount if coupon has max discount limit
      if ($coupon->max_discount_amount) {
        $discount = min($discount, $coupon->max_discount_amount);
      }
    } elseif ($coupon->discount_type === 'flat') {
      $discount = $coupon->discount_value;
    }

    //---------------------------
    // 7) PASS RESPONSE
    //---------------------------

    $data['coupon'] = $coupon;
    $data['discount_amount'] = $discount;

    return $data;
  }


  public function taxCalculate(Request $request, $course, float $amount)
  {

    $taxPercent = $course->is_tax == 'excluded' ? $course->tax_percentage : 0;

    $taxAmount = round(($taxPercent / 100) * $amount, 2);

    return [
      'tax_percent' => $taxPercent,
      'tax_amount'  => $taxAmount,
    ];
  }


  // PhonePe callback - POST endpoint called by gateway
  // IMPORTANT: validate signature, verify payment status with gateway
  // public function paymentCallback(Request $req)
  // {
  //   // PhonePe will POST response. Validate signature and transaction id.
  //   // This is a simplified example — implement proper verification.
  //   $payload = $req->all();
  //   $orderId = $payload['orderId'] ?? $req->input('order_id');
  //   $transactionId = $payload['transactionId'] ?? $req->input('transaction_id');
  //   $status = $payload['status'] ?? $req->input('status'); // success/failed

  //   // Find payment record by order_id
  //   $payment = PurchasePayment::where('order_id', $orderId)->first();
  //   if (!$payment) {
  //     // optionally log and return
  //     return response()->json(['ok' => false, 'msg' => 'unknown order'], 404);
  //   }

  //   // store raw payload
  //   $payment->payload = $payload;
  //   $payment->transaction_id = $transactionId ?? $payment->transaction_id;
  //   $payment->status = ($status == 'success' ? 'success' : 'failed');
  //   $payment->save();

  //   $purchase = $payment->purchase;

  //   // if success -> mark purchase paid and assign course
  //   if ($status == 'success') {
  //     // mark purchase paid
  //     $purchase->status = 'paid';
  //     $purchase->save();

  //     // mark payment record success already saved

  //     // allocate course to student: create pivot or record in student_courses table
  //     // Example: if you have student_courses pivot table:
  //     // $purchase->student->courses()->attach($purchase->course_id);

  //     // If you maintain a enrollments table, create entry here.
  //     // For demo: simply log or set an example flag.

  //     // mark installments paid if any as paid (optionally)
  //     foreach ($purchase->installments as $ins) {
  //       $ins->is_paid = true;
  //       $ins->paid_amount = $ins->amount;
  //       $ins->save();
  //     }

  //     // Return success
  //     return response()->json(['ok' => true, 'msg' => 'payment success']);
  //   } else {
  //     $purchase->status = 'failed';
  //     $purchase->save();
  //     return response()->json(['ok' => false, 'msg' => 'payment failed']);
  //   }
  // }

  // Optional success redirect (for demo)
  public function paymentSuccess(Request $req)
  {
    $purchase = Purchase::find($req->get('purchase_id'));
    if (!$purchase) abort(404);

    // For demo: mark as paid (simulate callback). In real flows, gateway calls server callback.
    DB::transaction(function () use ($purchase) {
      $purchase->status = 'paid';
      $purchase->save();

      // create a payment record to mark success if not present
      $purchase->payments()->create([
        'gateway' => 'phonepe',
        'transaction_id' => 'SIMULATED-' . now()->timestamp,
        'order_id' => $purchase->payments()->first()->order_id ?? 'SIM-' . now()->timestamp,
        'amount' => $purchase->grand_total,
        'status' => 'success',
        'payload' => ['simulated' => true],
      ]);

      // assign course to student (create pivot or attach)
      // Assuming Student has courses() belongsToMany via student_courses table:
      if (method_exists($purchase->student, 'courses')) {
        $purchase->student->courses()->attach($purchase->course_id);
      }
    });

    return redirect()->route('company.admissions.create')->with('success', 'Payment simulated and purchase marked paid.');
  }
}
