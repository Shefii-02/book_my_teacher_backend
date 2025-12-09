<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseInstallment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicController extends Controller
{
  public function admission()
  {
    $courses = Course::get();
    return view('company.academic.admission', compact('courses'));
  }

  // AJAX: course search
  public function courseSearch(Request $request)
  {
    $q = $request->get('q', '');
    $data = Course::where('title', 'like', "%{$q}%")->limit(30)->get(['id', 'title', 'net_price', 'actual_price', 'total_hours', 'started_at', 'ended_at', 'description']);
    return response()->json($data);
  }

  // AJAX: course info for selected course
  public function courseInfo($id)
  {
    $course = Course::findOrFail($id);
    return response()->json($course);
  }

  // AJAX: validate coupon
  public function validateCoupon(Request $request)
  {
    $code = $request->input('code');
    $coupon = Coupon::where('code', $code)->where('is_active', 1)->first();
    if (!$coupon) return response()->json(['ok' => false, 'message' => 'Invalid coupon']);
    // adapt fields: e.g. amount / percent / type
    return response()->json(['ok' => true, 'discount_amount' => $coupon->amount ?? 0, 'coupon' => $coupon]);
  }

  public function admissionStore(Request $request)
  {
    $request->validate([
      'student_id' => 'required|exists:students,id',
      'course_id'  => 'required|exists:courses,id',
      'price' => 'required|numeric|min:0',
      'discount_amount' => 'nullable|numeric|min:0',
      'grand_total' => 'required|numeric|min:0',
      'is_installment' => 'nullable|boolean',
      'installments_count' => 'nullable|integer|min:1',
      'installment_interval_months' => 'nullable|integer|min:1',
      'installments' => 'nullable|array',
      'installments.*.date' => 'nullable|date',
      'installments.*.amount' => 'nullable|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {
      $sc = StudentCourse::create([
        'student_id' => $request->student_id,
        'course_id'  => $request->course_id,
        'coupon_code' => $request->coupon_code,
        'price' => $request->price,
        'discount_amount' => $request->discount_amount ?? 0,
        'grand_total' => $request->grand_total,
        'is_installment' => $request->is_installment ? 1 : 0,
        'installments_count' => $request->installments_count,
        'installment_interval_months' => $request->installment_interval_months,
        'installment_additional_amount' => $request->installment_additional_amount ?? 0,
        'notes' => $request->notes,
        'status' => 'active',
        'created_by' => auth()->id() ?? null,
      ]);

      // create installments if provided
      if ($request->is_installment && is_array($request->installments)) {
        foreach ($request->installments as $ins) {
          // ensure amount cast
          $amount = floatval($ins['amount'] ?? 0);
          $date = !empty($ins['date']) ? Carbon::parse($ins['date'])->toDateString() : null;
          CourseInstallment::create([
            'student_course_id' => $sc->id,
            'due_date' => $date,
            'amount' => $amount,
            'paid_amount' => 0,
            'is_paid' => false,
          ]);
        }
      }
    });

    return redirect()->route('admin.admissions.create')->with('success', 'Purchase completed.');
  }
  public function courseSwap() {}
  public function courseSwapStore() {}
}
