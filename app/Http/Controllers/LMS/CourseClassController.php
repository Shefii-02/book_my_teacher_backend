<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\User;
use Illuminate\Http\Request;

class CourseClassController extends Controller
{
  public function index()
  {
    $classes = CourseClass::with(['course', 'teacher'])->latest()->paginate(10);
    return view('course_classes.index', compact('classes'));
  }

  public function create()
  {
    $courses = Course::all();
    $teachers = User::where('type', 'teacher')->get(); // filter teachers
    return view('course_classes.create', compact('courses', 'teachers'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'course_id'  => 'required|exists:courses,id',
      'teacher_id' => 'required|exists:users,id',
    ]);

    CourseClass::create($request->only('course_id', 'teacher_id'));

    return redirect()->route('course_classes.index')->with('success', 'Course class created successfully.');
  }

  public function edit(CourseClass $course_class)
  {
    $courses = Course::all();
    $teachers = User::where('type', 'teacher')->get();

    return view('course_classes.edit', [
      'class' => $course_class,
      'courses' => $courses,
      'teachers' => $teachers
    ]);
  }

  public function update(Request $request, CourseClass $course_class)
  {
    $request->validate([
      'course_id'  => 'required|exists:courses,id',
      'teacher_id' => 'required|exists:users,id',
    ]);

    $course_class->update($request->only('course_id', 'teacher_id'));

    return redirect()->route('course_classes.index')->with('success', 'Course class updated successfully.');
  }

  public function destroy(CourseClass $course_class)
  {
    $course_class->delete();
    return redirect()->route('course_classes.index')->with('success', 'Course class deleted successfully.');
  }
}
