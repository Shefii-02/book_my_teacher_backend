<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\MockObject\Builder\Identity;

class CourseController extends Controller
{
  public function index()
  {
    $courses = Course::with('category')->latest()->paginate(10);
    return view('company.courses.index', compact('courses'));
  }

  public function create(Request $request)
  {
    $course_identity            = $request->draft;
    $categories       = CourseCategory::all();
    $course_draft     = Course::where('course_identity', $course_identity)->first();

    return view('company.courses.form', compact('categories', 'course_draft'));
  }

  public function store(Request $request)
  {

    $company_id = 1;
    if ($request->basic_form) {
      $request->validate([
        'title'        => 'required|string|max:255',
        'description'  => 'nullable|string',
        'days'         => 'required',
        'hours'        => 'required',
        'started_at'    => 'required',
        'ended_at'     => 'required',
        'categories' => 'required|array',
        'categories.*.category_id' => 'required|exists:course_categories,id',
        'thumbnail'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'main_image'   => 'required|image|mimes:jpg,jpeg,png|max:2048',
      ]);

      $thumbnailPath = null;
      // Upload Icon
      if ($request->hasFile('thumbnail')) {
        $iconId = MediaHelper::uploadCompanyFile(
          $company_id,
          'courses/thumbnaile',
          $request->file('thumbnail'),
          'courses'
        );
        $thumbnailPath = $iconId;
      }

      $mainImagelPath = null;
      // Upload Main Image
      if ($request->hasFile('main_image')) {
        $mainImageId = MediaHelper::uploadCompanyFile(
          $company_id,
          'courses/main_images',
          $request->file('main_image'),
          'courses'
        );
        $mainImagelPath = $mainImageId;
      }


      $identityCode =  $company_id . now();
      $course = Course::create([
        'title'        => $request->title,
        'description'  => $request->description,
        'thumbnail_id' => $thumbnailPath,
        'mainimage_id' => $mainImagelPath,
        'started_at'    => $request->started_at,
        'ended_at'     => $request->ended_at,
        'total_hours'  => $request->hours,
        'company_id'   => $company_id,
        'created_by'   => Auth::id(),
        'step_completed' => 1,
        'course_identity' => $identityCode,
      ]);

      foreach ($request->categories as $catData) {
        $course->categories()->attach($catData['category_id'], [
          'subcategories' => json_encode($catData['subcategories'] ?? [])
        ]);
      }
    } else if ($request->pricing_form) {

      $request->validate([
        'course_identity'       => 'required',
        'actual_price'          => 'required|numeric|min:0',
        'discount_type'         => 'nullable|in:fixed,percentage',
        'discount_amount'       => 'nullable|numeric|min:0',
        'coupon_available'      => 'required|in:1,0',
        'is_tax'                => 'required|in:included,excluded',
        'tax_percentage'        => 'nullable|numeric|min:0|max:100',
        'discount_validity'     => 'nullable|in:limited,unlimited',
        'discount_validity_end' => 'nullable|date',
      ]);

      // 🔹 Find course or 404
      $course = Course::where('course_identity', $request->course_identity)
        ->where('company_id', 1)
        ->firstOrFail();

      // ✅ Input values
      $actualPrice   = floatval($request->actual_price);
      $discountType  = $request->discount_type ?? 'fixed';
      $discountAmt   = floatval($request->discount_amount ?? 0);
      $taxType       = $request->is_tax ?? 'included';
      $taxPercent    = floatval($request->tax_percentage ?? 0);

      // ✅ Calculate Discounted Price
      if ($discountType === 'fixed') {
        $discountedPrice = max(0, $actualPrice - $discountAmt);
      } elseif ($discountType === 'percentage') {
        $discountedPrice = max(0, $actualPrice - ($actualPrice * $discountAmt / 100));
      } else {
        $discountedPrice = $actualPrice;
      }

      // ✅ Calculate Gross & Net Prices
      $grossPrice = $discountedPrice;
      $netPrice   = $discountedPrice;

      if ($taxType === 'excluded' && $taxPercent > 0) {
        $netPrice = $discountedPrice + ($discountedPrice * $taxPercent / 100);
      }

      // ✅ Store Data
      $course->actual_price          = $actualPrice;
      $course->discount_type         = $discountType;
      $course->discount_amount       = $discountAmt;
      $course->discount_price        = $discountedPrice;
      $course->gross_price           = $grossPrice;
      $course->net_price             = $netPrice;
      $course->coupon_available      = $request->coupon_available;
      $course->is_tax                = $taxType;
      $course->tax_percentage        = $taxPercent;
      $course->discount_validity     = $request->discount_validity;
      $course->discount_validity_end = $request->discount_validity_end;
      $course->step_completed        = 2;
      $course->save();
    } else if ($request->advanced_form) {
      $request->validate([
        'course_identity'       => 'required',
        'video_type'            => 'required',
        'streaming_type'        => 'required',
        'has_material'          => 'required|in:1,0',
        'has_material_download' => 'nullable|in:1,0',
        'has_exam'              => 'nullable|in:1,0',
        'is_counselling'        => 'required|in:1,0',
        'is_career_guidance'    => 'required|in:1,0',
        'type'                  => 'required',
      ]);

      // 🔹 Find course or 404
      $course = Course::where('course_identity', $request->course_identity)
        ->where('company_id', 1)
        ->firstOrFail();

      $course->video_type             = $request->video_type;
      $course->has_material           = $request->has_material;
      $course->has_material_download  = $request->has_material_download;
      $course->streaming_type         = $request->streaming_type;
      $course->has_exam               = $request->has_exam;
      $course->is_counselling         = $request->is_counselling;
      $course->is_career_guidance     = $request->is_career_guidance;
      $course->type                   = $request->type;
      $course->step_completed         = 3;
      $course->save();
    }

    // // // //  ``, ``, `video_type`, `has_material`,
    // // // `has_material_download`, `streaming_type`, `has_exam`,
    // // //  `is_counselling`, `is_career_guidance`, `company_id`,
    // // ``, `type`





    return redirect()->route('admin.courses.create', ['draft' => $course->course_identity])->with('success', 'Course created successfully.');
  }

  public function edit(Course $course)
  {
    $categories = CourseCategory::all();
    return view('company.courses.edit', compact('course', 'categories'));
  }

  public function update(Request $request, Course $course)
  {
    $request->validate([
      'title'        => 'required|string|max:255',
      'description'  => 'nullable|string',
      'category_id'  => 'required|exists:course_category,id',
      'duration'     => 'required|integer',
      'duration_type' => 'required|string|in:minutes,hours,days',
      'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $thumbnailPath = $course->thumbnail;
    if ($request->hasFile('thumbnail')) {
      if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
        Storage::disk('public')->delete($thumbnailPath);
      }
      $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
    }

    $course->update([
      'title'        => $request->title,
      'description'  => $request->description,
      'thumbnail'    => $thumbnailPath,
      'category_id'  => $request->category_id,
      'duration'     => $request->duration,
      'duration_type' => $request->duration_type,
      'stated_at'    => $request->stated_at,
      'ended_at'     => $request->ended_at,
    ]);

    return redirect()->route('company.courses.index')->with('success', 'Course updated successfully.');
  }

  public function destroy(Course $course)
  {
    if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
      Storage::disk('public')->delete($course->thumbnail);
    }

    $course->delete();

    return redirect()->route('company.courses.index')->with('success', 'Course deleted successfully.');
  }

  public function loadStepForm($step = 0, Request $request)
  {
    $course     = Course::where('course_identity', $request->course_id)->first();
    if ($step  == 1) {
      $categories       = CourseCategory::all();
      return view('company.courses.steps.basic', compact('course', 'categories'));
    } else if ($step  == 2) {
      return view('company.courses.steps.payments', compact('course'));
    } else if ($step  == 3) {
      return view('company.courses.steps.advanced', compact('course'));
    } else {
      return view('company.courses.steps.overview', compact('course'));
    }
  }

  public function getSubcategories($id)
  {
    $subcategories = CourseSubCategory::where('category_id', $id)->select('id', 'title')->get();
    return response()->json($subcategories);
  }
}
