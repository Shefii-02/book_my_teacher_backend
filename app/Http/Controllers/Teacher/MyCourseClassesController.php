<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\TeacherClass;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyCourseClassesController extends Controller
{
  public function index($identity)
  {
    $course = Course::with('classes')->where('course_identity', $identity)->first() ?? abort(404);
    return view('teacher.my_courses.classes.index', compact('course'));
  }

  public function create($identity)
  {
    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $teachers = User::where('acc_type', 'teacher')->get(); // filter teachers
    return view('teacher.my_courses.classes.form', compact('course', 'teachers'));
  }

  public function store(Request $request, $identity)
  {
    $course = Course::where('course_identity', $identity)->firstOrFail();

    // Ensure first class created by admin
    $courseClass = CourseClass::where('course_id', $course->id)
      ->withMeetingLink()
      // ->whereNotNull('meeting_link')
      // ->where('meeting_link', '!=', '')
      ->latest('scheduled_at')
      ->first();

    if (!$courseClass) {
      return back()->with('error', 'First class creation only possible by admin. Please contact support.');
    }

    $validated = $request->validate([
      'scheduled_at' => 'required|date',
      'title'        => 'required|string|max:255',
      'description'  => 'nullable|string',
      'start_time'   => 'required|date_format:H:i',
      'end_time'     => 'required|date_format:H:i|after:start_time',
      'priority'     => 'required|integer',
      'status'       => 'required|string',
    ]);

    $teacherId = $course->teacher_id;

    if (!$teacherId) {
      return back()->with('error', 'Teacher not assigned to this course.');
    }

    try {
      DB::beginTransaction();

      $data = $validated;
      $data['course_id']    = $course->id;
      $data['teacher_id']   = $teacherId;
      $data['type']         = 'online';
      $data['class_mode']   = 'gmeet';
      $data['meeting_link'] = $courseClass->meeting_link;

      $data['start_time'] = date(
        'Y-m-d H:i:s',
        strtotime($validated['scheduled_at'] . ' ' . $validated['start_time'])
      );

      $data['end_time'] = date(
        'Y-m-d H:i:s',
        strtotime($validated['scheduled_at'] . ' ' . $validated['end_time'])
      );

      $class = CourseClass::create($data);

      TeacherClass::create([
        'teacher_id' => $teacherId,
        'class_id'   => $class->id
      ]);

      DB::commit();

      return redirect()
        ->route('teacher.my-courses.schedule-class.index', $course->course_identity)
        ->with('success', 'Course class created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', $e->getMessage());
    }
  }


  public function edit($identity, $course_class)
  {

    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $class = CourseClass::with('teachers')->where('course_id', $course->id)->where('id', $course_class)->first() ?? abort(404);

    $teachers = User::where('acc_type', 'teacher')->get();

    return view('teacher.my_courses.classes.form', [
      'class' => $class,
      'course' => $course,
      'teachers' => $teachers
    ]);
  }

  public function update($identity, Request $request, $course_class)
  {

    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $class = CourseClass::where('course_id', $course->id)->where('id', $course_class)->first() ?? abort(404);
    $validated = $request->validate([
      'scheduled_at' => 'required|date',
      'title'        => 'required|string|max:255',
      'description'  => 'nullable|string',
      'start_time'   => 'required|date_format:H:i',
      'end_time'     => 'required|date_format:H:i|after:start_time',
      'priority'     => 'required|integer',
      'status'       => 'required|string',
    ]);

    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    try {
      DB::beginTransaction();
      $class->update($validated);
      DB::commit();
      return redirect()->route('teacher.my-courses.schedule-class.index', $course->course_identity)->with('success', 'Course class updated successfully.');
    } catch (Exception $e) {
      dd($request->all(),$e->getMessage());
      DB::rollBack();
      return redirect()->back()->with('errro', $e->getMessage());
    }
  }

  public function destroy($identity,  $course_class)
  {
    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $class = CourseClass::where('course_id', $course->id)->where('id', $course_class)->first() ?? abort(404);
    $class->delete();
    return redirect()->route('teacher.my-courses.schedule-class.index', $identity)->with('success', 'Course class deleted successfully.');
  }
}
