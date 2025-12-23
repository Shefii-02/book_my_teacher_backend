<?php

namespace App\Http\Controllers\LMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSubCategory;
use App\Models\Teacher;
use App\Models\TeacherCourse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    $course_draft = null;

    if ($course_identity != null) {
      $course_draft     = Course::where('course_identity', $course_identity)->first();
    }

    return view('company.courses.form', compact('categories', 'course_draft'));
  }

  public function store(Request $request)
  {

    DB::beginTransaction();
    try {
      $company_id = auth()->user()->company_id;

      if ($request->basic_form) {
        // Determine if this is a create or update action
        $isUpdate = $request->filled('course_id');

        // Validation rules
        $rules = [
          'title'        => 'required|string|max:255',
          'description'  => 'nullable|string',
          'duration'         => 'required',
          'total_hours'        => 'required',
          'started_at'   => 'required|date',
          'ended_at'     => 'required|date|after_or_equal:started_at',
          'categories'   => 'required|array',
          'categories.*.category_id' => 'nullable|exists:course_categories,id',
        ];


        // Only require images if creating new course
        if ($isUpdate) {
          $rules['thumbnail'] = 'nullable|image|mimes:jpg,jpeg,png';
          $rules['main_image'] = 'nullable|image|mimes:jpg,jpeg,png';
        } else {
          $rules['thumbnail'] = 'required|image|mimes:jpg,jpeg,png';
          $rules['main_image'] = 'required|image|mimes:jpg,jpeg,png';
        }

        $request->validate($rules);

        // Upload Thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
          $thumbnailPath = MediaHelper::uploadCompanyFile(
            $company_id,
            'courses/thumbnails',
            $request->file('thumbnail'),
            'courses'
          );
        }

        // Upload Main Image
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
          $mainImagePath = MediaHelper::uploadCompanyFile(
            $company_id,
            'courses/main_images',
            $request->file('main_image'),
            'courses'
          );
        }

        // --- UPDATE or CREATE ---
        if ($isUpdate) {
          $course = Course::where('course_identity', $request->course_id)
            ->where('company_id', $company_id)
            ->firstOrFail();

          $updateData = [
            'title'        => $request->title,
            'description'  => $request->description,
            'started_at'   => $request->started_at,
            'ended_at'     => $request->ended_at,
            'duration'       => $request->duration,
            'total_hours'    => $request->total_hours,
          ];

          // Only update images if new ones are uploaded
          if ($thumbnailPath) $updateData['thumbnail_id'] = $thumbnailPath;
          if ($mainImagePath) $updateData['mainimage_id'] = $mainImagePath;

          $course->update($updateData);
        } else {
          $identityCode = $company_id . date('YmdHis');
          $course = Course::create([
            'title'          => $request->title,
            'description'    => $request->description,
            'thumbnail_id'   => $thumbnailPath,
            'mainimage_id'   => $mainImagePath,
            'started_at'     => $request->started_at,
            'ended_at'       => $request->ended_at,
            'duration'       => $request->duration,
            'total_hours'    => $request->total_hours,
            'company_id'     => $company_id,
            'created_by'     => Auth::id(),
            'step_completed' => 1,
            'course_identity' => $identityCode,
          ]);
        }

        // --- Attach Categories & Subcategories ---
        if ($request->filled('categories')) {
          $syncData = [];
          foreach ($request->categories as $catData) {
            $syncData[$catData['category_id']] = [
              'subcategories' => json_encode($catData['subcategories'] ?? []),
            ];
          }
          $course->categories()->sync($syncData);
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
        if ($course->step_completed <= 2) {
          $course->step_completed        = 2;
        }
        $course->save();
      } else if ($request->advanced_form) {

        $request->validate([
          'course_identity'       => 'required',
          'course_type'           => 'required',
          'class_type'            => 'required',
          // 'course_level'          => 'required',
          // 'class_mode'            => 'required',
          // 'has_material'          => 'required|in:1,0',
          // 'has_material_download' => 'nullable|in:1,0',
          // 'has_exam'              => 'nullable|in:1,0',
          // 'is_counselling'        => 'required|in:1,0',
          // 'is_career_guidance'    => 'required|in:1,0',
        ]);

        // 🔹 Find course or 404
        $course = Course::where('course_identity', $request->course_identity)
          ->where('company_id', 1)
          ->firstOrFail();
        $course->course_type            = $request->course_type;
        $course->level                  = $request->course_level;
        $course->class_mode             = $request->class_mode;
        $course->class_type             = $request->class_type;
        $course->has_material           = $request->has_material == '1' ? 1 : 0;
        $course->has_material_download  = $request->has_material_download == '1'  ? 1 : 0;
        $course->has_exam               = $request->has_exam == '1'  ? 1 : 0;
        $course->is_counselling         = $request->is_counselling == '1'  ? 1 : 0;
        $course->is_career_guidance     = $request->is_career_guidance == '1'  ? 1 : 0;
        if ($course->step_completed <= 3) {
          $course->step_completed        = 3;
        }
        $course->commission_percentage  = $request->is_commission ? $request->commission_percentage : 0;
        $course->institude_id           = $request->is_institute ? $request->institute_id : null;
        $course->save();

        TeacherCourse::where('course_id', $course->id)->delete();
        if (is_array($request->teachers)) {
          $teachers = $request->teachers;
        } else {
          $teachers[] = $request->teachers;
        }

        if ($teachers) {
          foreach ($teachers ?? [] as $teacher) {
            $teachersCourse             = new TeacherCourse();
            $teachersCourse->course_id  = $course->id;
            $teachersCourse->teacher_id = $teacher;
            $teachersCourse->save();
          }
        }
      } else if ($request->overview_form) {

        $request->validate([
          'course_identity'       => 'required',
          'status'            => 'required',
        ]);

        // 🔹 Find course or 404
        $course = Course::where('course_identity', $request->course_identity)
          ->where('company_id', 1)
          ->firstOrFail();

        $course->status  = $request->status;
        if ($course->step_completed <= 4) {
          $course->step_completed         = 4;
        }
        $course->save();
        DB::commit();
        return redirect()->route('company.courses.index', ['draft' => $course->course_identity])->with('success', 'Course created successfully.');
      }
      DB::commit();
      return redirect()->route('company.courses.create', ['draft' => $course->course_identity])->with('success', 'Course created successfully.');
    } catch (Exception $e) {

      DB::rollBack();
      return redirect()->back()->with('error', 'Course creation error' . $e->getMessage());
    }
  }

  public function show($id)
  {
    $course     = Course::where('course_identity', $id)->first();
    return view('company.courses.show', compact('course'));
  }

  // public function edit(Course $course)
  // {
  //   $categories = CourseCategory::all();
  //   return view('company.courses.edit', compact('course', 'categories'));
  // }

  // public function update(Request $request, Course $course)
  // {
  //   $request->validate([
  //     'title'        => 'required|string|max:255',
  //     'description'  => 'nullable|string',
  //     'category_id'  => 'required|exists:course_category,id',
  //     'duration'     => 'required|integer',
  //     'duration_type' => 'required|string|in:minutes,hours,days',
  //     'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
  //   ]);

  //   $thumbnailPath = $course->thumbnail;
  //   if ($request->hasFile('thumbnail')) {
  //     if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
  //       Storage::disk('public')->delete($thumbnailPath);
  //     }
  //     $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
  //   }

  //   $course->update([
  //     'title'        => $request->title,
  //     'description'  => $request->description,
  //     'thumbnail'    => $thumbnailPath,
  //     'category_id'  => $request->category_id,
  //     'duration'     => $request->duration,
  //     'duration_type' => $request->duration_type,
  //     'stated_at'    => $request->stated_at,
  //     'ended_at'     => $request->ended_at,
  //   ]);

  //   return redirect()->route('company.courses.index')->with('success', 'Course updated successfully.');
  // }

  public function destroy(Course $course)
  {
    DB::beginTransaction();
    // if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
    //   Storage::disk('public')->delete($course->thumbnail);
    // }
    try {
      if ($course->thumbnail_id) {
        MediaHelper::removeCompanyFile($course->thumbnail_id);
      }
      if ($course->mainimage_id) {
        MediaHelper::removeCompanyFile($course->mainimage_id);
      }

      $course->delete();
      DB::commit();
      return redirect()->route('company.courses.index')->with('success', 'Course deleted successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Course creation error' . $e->getMessage());
    }
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
      $teachers = Teacher::where('published', 1)->get();
      return view('company.courses.steps.advanced', compact('course', 'teachers'));
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
