<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\TeacherClass;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseClassController extends Controller
{
  public function index($identity)
  {
    $course = Course::with('classes')->where('course_identity', $identity)->first() ?? abort(404);
    return view('company.courses.classes.index', compact('course'));
  }

  public function create($identity)
  {
    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $teachers = User::where('acc_type', 'teacher')->get(); // filter teachers
    return view('company.courses.classes.form', compact('course', 'teachers'));
  }

  public function store(Request $request, $identity)
  {

    $course = Course::where('course_identity', $identity)->first() ?? abort(404);

    $validated = $request->validate([
      'teacher_id'       => 'required',
      'scheduled_at'     => 'required',
      'type'             => 'required|in:online,offline,recorded',
      'title'            => 'required|string|max:255',
      'description'      => 'nullable|string',

      'start_time'       => 'required',
      'end_time'       => 'required',
      'priority' => 'required',
      'status' => 'required',

      // dynamic fields
      'class_mode'       => 'nullable|required_if:type,online',
      'meeting_link'     => 'nullable|required_if:type,online',

      // 'class_address'    => 'nullable|required_if:type,offline',

      'recording_url'    => 'nullable|required_if:type,recorded',
    ]);

    try {

      DB::beginTransaction();
      $data = $validated;
      $data['course_id'] = $course->id;

      $data['start_time'] = date('Y-m-d H:i', strtotime($data['scheduled_at'] . ' ' . $data['start_time']));
      $data['end_time'] = date('Y-m-d H:i', strtotime($data['scheduled_at'] . ' ' . $data['end_time']));


      $class = CourseClass::create($data);

      TeacherClass::create(['teacher_id' => $request->teacher_id, 'class_id' => $class->id]);

      DB::commit();
      return redirect()->route('company.courses.schedule-class.index', $course->course_identity)->with('success', 'Course class created successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function edit($identity, $course_class)
  {

    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $class = CourseClass::with('teachers')->where('course_id', $course->id)->where('id', $course_class)->first() ?? abort(404);

    $teachers = User::where('acc_type', 'teacher')->get();

    return view('company.courses.classes.form', [
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
      'teacher_id'       => 'required',
      'scheduled_at'     => 'required',
      'type'             => 'required|in:online,offline,recorded',
      'title'            => 'required|string|max:255',
      'description'      => 'nullable|string',

      'start_time'       => 'required',
      'end_time'         => 'required',
      'priority'         => 'required',
      'status'           => 'required',

      'class_mode'       => 'nullable|required_if:type,online',
      'meeting_link'     => 'nullable|required_if:type,online',

      'class_address'    => 'nullable|required_if:type,offline',

      'recording_url'    => 'nullable|required_if:type,recorded',
    ]);

    // $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    try {
      DB::beginTransaction();
      dd($validated);
      $class->update($validated);
      DB::commit();
      return redirect()->route('company.courses.schedule-class.index', $course->course_identity)->with('success', 'Course class updated successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('errro', $e->getMessage());
    }
  }

  public function destroy($identity,  $course_class)
  {
    $course = Course::where('course_identity', $identity)->first() ?? abort(404);
    $class = CourseClass::where('course_id', $course->id)->where('id', $course_class)->first() ?? abort(404);
    $class->delete();
    return redirect()->route('company.courses.schedule-class.index', $identity)->with('success', 'Course class deleted successfully.');
  }
}
