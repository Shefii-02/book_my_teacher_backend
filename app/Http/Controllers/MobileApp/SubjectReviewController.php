<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSubCategory;
use Illuminate\Http\Request;
use App\Models\SubjectReview;
use App\Models\TeacherCourse;
use App\Models\User;
use Exception;

class SubjectReviewController extends Controller
{
  // List all reviews
  public function index()
  {
    $reviews = SubjectReview::with(['subject', 'user', 'teacher'])->latest()->paginate(10);
    return view('company.mobile-app.reviews.index', compact('reviews'));
  }

  // Show create form
  public function create()
  {
    return view('company.mobile-app.reviews.form');
  }

  // Store new review
  public function store(Request $request)
  {
    $request->validate([
      'subject_id' => 'required',
      'user_id' => 'required|integer',
      'teacher_id' => 'nullable|integer',
      'course_id' => 'nullable',
      'comments' => 'required|string',
      'rating' => 'required|integer|min:1|max:5',
    ]);

    try {
      SubjectReview::create($request->all());
      return redirect()->route('company.app.reviews.index')->with('success', 'Review created successfully!');
    } catch (Exception $e) {
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  // Show edit form
  public function edit(SubjectReview $review)
  {
    return view('company.mobile-app.reviews.edit', compact('review'));
  }

  // Update review
  public function update(Request $request, SubjectReview $review)
  {
    $request->validate([

      'comments' => 'required|string',
      'rating' => 'required|min:1|max:5',
    ]);

    $review->update($request->all());

    return redirect()->route('company.app.reviews.index')->with('success', 'Review updated successfully!');
  }

  // Delete review
  public function destroy(SubjectReview $review)
  {
    $review->delete();
    return redirect()->route('company.app.reviews.index')->with('success', 'Review deleted successfully!');
  }



  public function studentDetails($student)
  {
    $company_id = auth()->user()->company_id;
    $student = User::where('id', $student)->where('company_id', $company_id)->first();
    // Purchased courses (adjust relation names if needed)

    $courses = $student->registrations()
      // ->with('course')
      ->get()
      ->map(fn($c) => [
        'id'   => $c->course->id,
        'name' => $c->course->title,
      ]);

    return response()->json([
      'courses' => $courses
    ]);
  }

  public function  courseDetails($courseId)
  {
    $course = Course::with('teachers')->where('id', $courseId)->first();

    $teacher_courses = $course->teachers()->get()
      ->map(fn($t) => [
        'id'   => $t->id,
        'name' => $t->name,
      ]);

    return response()->json([
      'teachers' => $teacher_courses
    ]);
  }

  public function courseSubjects($courseId)
  {
    $course = Course::with('categories')->findOrFail($courseId);

    /* 1️⃣ Collect & merge all pivot_subcategories */
    // $subcategoryIds = $course->categories
    //   ->pluck('pivot.subcategories')   // get JSON strings
    //   ->filter()                              // remove nulls
    //   ->flatMap(fn($json) => is_array(json_decode($json, true))
    //     ? json_decode($json, true)
    //     : [])->unique()
    //   ->values()
    //   ->toArray();
    $subcategoryIds = $course->categories
      ->pluck('pivot.subcategories')
      ->filter()
      ->flatMap(fn($json) => array_map('intval', json_decode($json, true)))
      ->unique()
      ->values()
      ->all();

    // ->flatMap(fn($json) => json_decode($json, true)) // decode + flatten



    /* 2️⃣ Fetch subcategories using whereIn */
    $subcategories = CourseSubCategory::whereIn('id', $subcategoryIds)
      ->select('id', 'title')
      ->get()
      ->unique('title')
      ->map(fn($s) => [
        'id'    => $s->id,
        'title' => $s->title,
      ]);

    return response()->json([
      'subjects' => $subcategories
    ]);
  }
}
