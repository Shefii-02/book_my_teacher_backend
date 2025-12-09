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
use Illuminate\Support\Str;

class AdmissionController extends Controller
{
  public function create(Request $request)
  {
    // for create/edit form you may pass $purchase for edit; here create
    return view('company.academic.admissions.form', [
      'teachers' => [], // optional
    ]);
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
    $data = Course::where('title', 'like', "%{$q}%")->limit(30)->get(['id', 'title', 'net_price', 'actual_price', 'total_hours', 'started_at', 'ended_at', 'description', 'is_tax']);
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
    $subtotal  = $req->subtotal;
    $code      = $req->code;

    if (!$studentId || !$courseId || !$subtotal) {
      return response()->json(['ok' => false, 'message' => 'Missing required fields']);
    }

    $now = now();

    // Load coupon with course relation
    $coupon = Coupon::with('coupon_course')
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
    } elseif ($coupon->discount_type === 'fixed') {
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
  public function store(Request $req)
  {
    $req->validate([
      'student_id' => 'required|exists:students,id',
      'course_id' => 'required|exists:courses,id',
      'price' => 'required|numeric|min:0',
      'discount_amount' => 'nullable|numeric|min:0',
      'tax_percent' => 'nullable|numeric|min:0',
      'grand_total' => 'required|numeric|min:0',
      'is_installment' => 'nullable|boolean',
      'installments' => 'nullable|array',
    ]);

    DB::beginTransaction();
    try {
      $purchase = Purchase::create([
        'student_id' => $req->student_id,
        'course_id' => $req->course_id,
        'coupon_code' => $req->coupon_code ?? null,
        'price' => $req->price,
        'discount_amount' => $req->discount_amount ?? 0,
        'tax_amount' => round((($req->tax_percent ?? 0) / 100) * ($req->price - ($req->discount_amount ?? 0)), 2),
        'grand_total' => $req->grand_total,
        'is_installment' => $req->is_installment ? 1 : 0,
        'installments_count' => $req->installments_count,
        'installment_interval_months' => $req->installment_interval_months,
        'installment_additional_amount' => $req->installment_additional_amount ?? 0,
        'notes' => $req->notes ?? null,
        'status' => 'pending', // initial pending
        'created_by' => auth()->id(),
        'tax_included' => $req->tax_included ? 1 : 0,
        'tax_percent' => $req->tax_percent ?? 0,
      ]);

      // installments creation (if provided)
      if ($purchase->is_installment && is_array($req->installments)) {
        foreach ($req->installments as $ins) {
          PurchaseInstallment::create([
            'purchase_id' => $purchase->id,
            'due_date' => $ins['date'] ?? null,
            'amount' => $ins['amount'] ?? 0,
            'paid_amount' => 0,
            'is_paid' => false,
          ]);
        }
      }

      // create payment record (initiated)
      $orderId = 'ORDER-' . Str::upper(Str::random(10)) . '-' . $purchase->id;
      $payment = PurchasePayment::create([
        'purchase_id' => $purchase->id,
        'gateway' => 'phonepe',
        'order_id' => $orderId,
        'amount' => $purchase->grand_total,
        'currency' => 'INR',
        'status' => 'initiated',
      ]);

      DB::commit();

      // Now redirect to PhonePe (or return a form to post) - stub code below
      // You must integrate actual PhonePe checkout request & signature here.
      // For demo we will redirect to a "mock payment page" route; replace with real gateway URL.

      // Example: build PhonePe payload and redirect to gateway
      // For security: sign payload with secret key, use server-to-server verification.

      // For demo: redirect to local success route after small delay (simulate)
      // In production: redirect to actual gateway checkout URL with signed payload

      // Example redirect to an internal "simulate" endpoint (for dev)
      return redirect()->route('admin.admissions.payment.success', ['purchase_id' => $purchase->id]);
    } catch (\Throwable $ex) {
      DB::rollBack();
      return back()->withErrors(['error' => $ex->getMessage()]);
    }
  }

  // PhonePe callback - POST endpoint called by gateway
  // IMPORTANT: validate signature, verify payment status with gateway
  public function paymentCallback(Request $req)
  {
    // PhonePe will POST response. Validate signature and transaction id.
    // This is a simplified example — implement proper verification.
    $payload = $req->all();
    $orderId = $payload['orderId'] ?? $req->input('order_id');
    $transactionId = $payload['transactionId'] ?? $req->input('transaction_id');
    $status = $payload['status'] ?? $req->input('status'); // success/failed

    // Find payment record by order_id
    $payment = PurchasePayment::where('order_id', $orderId)->first();
    if (!$payment) {
      // optionally log and return
      return response()->json(['ok' => false, 'msg' => 'unknown order'], 404);
    }

    // store raw payload
    $payment->payload = $payload;
    $payment->transaction_id = $transactionId ?? $payment->transaction_id;
    $payment->status = ($status == 'success' ? 'success' : 'failed');
    $payment->save();

    $purchase = $payment->purchase;

    // if success -> mark purchase paid and assign course
    if ($status == 'success') {
      // mark purchase paid
      $purchase->status = 'paid';
      $purchase->save();

      // mark payment record success already saved

      // allocate course to student: create pivot or record in student_courses table
      // Example: if you have student_courses pivot table:
      // $purchase->student->courses()->attach($purchase->course_id);

      // If you maintain a enrollments table, create entry here.
      // For demo: simply log or set an example flag.

      // mark installments paid if any as paid (optionally)
      foreach ($purchase->installments as $ins) {
        $ins->is_paid = true;
        $ins->paid_amount = $ins->amount;
        $ins->save();
      }

      // Return success
      return response()->json(['ok' => true, 'msg' => 'payment success']);
    } else {
      $purchase->status = 'failed';
      $purchase->save();
      return response()->json(['ok' => false, 'msg' => 'payment failed']);
    }
  }

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

    return redirect()->route('admin.admissions.create')->with('success', 'Payment simulated and purchase marked paid.');
  }
}
