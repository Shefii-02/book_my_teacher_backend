<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
  public function index()
  {
    $coupons = Coupon::latest()->paginate('10');

    return view('company.coupons.index', compact('coupons'));
  }

  public function create()
  {
    $courses = Course::get();
    return view('company.coupons.form', compact('courses'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'offer_name' => 'required|string|max:255',
      'offer_code' => 'required|string|max:100|unique:coupons,offer_code',
      'coupon_type' => 'required|in:public,private',
      'discount_type' => 'required|in:flat,percentage',
      'start_date_time' => 'required|date',
    ]);

    $coupon = Coupon::create([
      'company_id' =>  1,
      'offer_name' => $request->offer_name,
      'offer_code' => $request->offer_code,
      'coupon_type' => $request->coupon_type,
      'discount_type' => $request->discount_type,
      'discount_value' => $request->discount_type == 'flat' ? $request->discount_value : null,
      'discount_percentage' => $request->discount_type == 'percentage' ? $request->discount_percentage : null,
      'max_discount' => $request->max_discount,
      'start_date_time' => $request->start_date_time,
      'end_date_time' => $request->is_unlimited ? null : $request->end_date_time,
      'is_unlimited' => $request->boolean('is_unlimited'),
      'minimum_order_value' => $request->minimum_order_value,
      'course_selection_type' => $request->course_selection_type,
      'show_inside_courses' => $request->boolean('show_inside_courses'),
      'max_usage_per_student' => $request->is_unlimited_usage ? null : $request->max_usage_per_student,
      'is_unlimited_usage' => $request->boolean('is_unlimited_usage'),
    ]);

    if ($request->course_selection_type === 'specific' && $request->has('course_ids')) {
      $coupon->courses()->sync($request->course_ids);
    }

    return redirect()->route('company.coupons.index')->with('success', 'Coupon created successfully!');
  }



  public function edit(Coupon $coupon)
  {
        $courses = Course::get();
        $couponCourses = $coupon->courses->pluck('id')->toArray();
    return view('company.coupons.form', compact('coupon','courses','couponCourses'));
  }

  public function update(Request $request, Coupon $coupon)
  {
    $validated = $request->validate([
      'offer_name' => 'required|string|max:255',
      'offer_code' => 'required|string|max:100|unique:coupons,offer_code,' . $coupon->id,
      'coupon_type' => 'required|in:public,private',
      'discount_type' => 'required|in:flat,percentage',
      'start_date_time' => 'required|date',
    ]);

    $coupon->update([
      'offer_name' => $request->offer_name,
      'offer_code' => $request->offer_code,
      'coupon_type' => $request->coupon_type,
      'discount_type' => $request->discount_type,
      'discount_value' => $request->discount_type == 'flat' ? $request->discount_value : null,
      'discount_percentage' => $request->discount_type == 'percentage' ? $request->discount_percentage : null,
      'max_discount' => $request->max_discount,
      'start_date_time' => $request->start_date_time,
      'end_date_time' => $request->is_unlimited ? null : $request->end_date_time,
      'is_unlimited' => $request->boolean('is_unlimited'),
      'minimum_order_value' => $request->minimum_order_value,
      'course_selection_type' => $request->course_selection_type,
      'show_inside_courses' => $request->boolean('show_inside_courses'),
      'max_usage_per_student' => $request->is_unlimited_usage ? null : $request->max_usage_per_student,
      'is_unlimited_usage' => $request->boolean('is_unlimited_usage'),
    ]);

    if ($request->course_selection_type === 'specific' && $request->has('course_ids')) {
      $coupon->courses()->sync($request->course_ids);
    } else {
      $coupon->courses()->detach();
    }

    return redirect()->route('company.coupons.index')->with('success', 'Coupon updated successfully!');
  }

  public function destroy(Coupon $coupon)
  {
    $coupon->delete();
    return redirect()->route('company.coupons.index')->with('success', 'Coupon deleted.');
  }


  public function trashed()
  {
    $coupons = Coupon::onlyTrashed()->get();
    return view('company.coupons.trashed', compact('coupons'));
  }

  public function restore($id)
  {
    $coupon = Coupon::onlyTrashed()->findOrFail($id);
    $coupon->restore();

    return redirect()->route('company.coupons.index')->with('success', 'Coupon restored successfully!');
  }

  public function forceDelete($id)
  {
    $coupon = Coupon::onlyTrashed()->findOrFail($id);
    $coupon->forceDelete();

    return redirect()->route('company.coupons.index')->with('success', 'Coupon permanently deleted.');
  }
}
