<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
  public function index()
  {
    $courses = Course::with('category')->latest()->paginate(10);
    return view('company.courses.index', compact('courses'));
  }

  public function create()
  {
    $categories = CourseCategory::all();
    return view('company.courses.form', compact('categories'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'title'        => 'required|string|max:255',
      'description'  => 'nullable|string',
      'category_id'  => 'required|exists:course_category,id',
      'duration'     => 'required|integer',
      'duration_type' => 'required|string|in:minutes,hours,days',
      'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
      $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
    }

    Course::create([
      'title'        => $request->title,
      'description'  => $request->description,
      'thumbnail'    => $thumbnailPath,
      'category_id'  => $request->category_id,
      'duration'     => $request->duration,
      'duration_type' => $request->duration_type,
      'stated_at'    => $request->stated_at,
      'ended_at'     => $request->ended_at,
      'company_id'   => Auth::user()->company_id ?? null,
      'created_by'   => Auth::id(),
    ]);

    return redirect()->route('company.courses.index')->with('success', 'Course created successfully.');
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
}
