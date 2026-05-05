<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassDuration;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\TeacherClass;
use App\Models\User;
use App\Notifications\NotificationActions;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseClassController extends Controller
{

  public function __construct(
    protected NotificationActions $notificationActions
  ) {}


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

      $data['created_by'] = auth()->user()->id;

      $class = CourseClass::create($data);

      TeacherClass::create(['teacher_id' => $request->teacher_id, 'class_id' => $class->id]);

      $this->notificationActions->courseClassStarted($class);

      // app(\App\Notifications\NotificationActions::class)->courseClassStarted($class);

      DB::commit();
      return redirect()->route('company.courses.schedule-class.index', $course->course_identity)->with('success', 'Course class created successfully.');
    } catch (Exception $e) {
      Log::info($e->getMessage());
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
      $validated['start_time'] = date('Y-m-d H:i', strtotime($validated['scheduled_at'] . ' ' . $validated['start_time']));
      $validated['end_time'] = date('Y-m-d H:i', strtotime($validated['scheduled_at'] . ' ' . $validated['end_time']));

      $data['updated_by'] = auth()->user()->id;

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



  public function attendanceTake($identity, $classId)
  {

    // Load class with attendance and student user
    $class = CourseClass::with([
      'attendance.user'
    ])->findOrFail($classId);

    /*
      If attendance already exists, use existing records
    */
    if ($class->attendance->count() > 0) {

      $students = $class->attendance->map(function ($item) {

        return [
          'id'         => $item->id,
          "student_id" => $item->student_id,
          "name" => $item->user->name ?? '',
          "roll_number" => $item->user->roll_number ?? '',
          "initials" => $this->getInitials($item->user->name ?? ''),
          "avatar_color" => "#4A47B0",
          "status" => $item->status ?? "none",
        ];
      });


      return view('company.courses.classes.attendance', compact('students', 'class'));
    }

    /*
      No attendance found:
      Get enrolled students from course and create attendance rows
    */

    // Example assumes class belongs to a course
    // and course has enrolled students relation

    $course = $class->course; // class belongsTo course

    $members = $course->students;
    /*
      Example relation:
      Course -> belongsToMany(User::class,'course_students','course_id','student_id')
    */

    foreach ($members ?? [] as $student) {


      Attendance::firstOrCreate([
        'course_id' => $class->course_id,
        'class_id' => $class->id,
        'student_id' => $student->id
      ], [
        'status' => 'none'
      ]);
    }

    /*
      Reload attendance after insert
    */

    $class->load('attendance.user');

    $students = $class->attendance->map(function ($item) {

      return [
        "id"        => $item->id,
        "student_id" => $item->student_id,
        "name" => $item->user->name ?? '',
        "roll_number" => $item->user->roll_number ?? '',
        "initials" => $this->getInitials($item->user->name ?? ''),
        "avatar_color" => "#4A47B0",
        "status" => $item->status ?? "none",
      ];
    });


    return view('company.courses.classes.attendance', compact('students', 'class'));
  }

  /*
Helper
*/
  private function getInitials($name)
  {
    return collect(explode(' ', $name))
      ->map(fn($part) => strtoupper(substr($part, 0, 1)))
      ->take(2)
      ->implode('');
  }

  public function attendanceUpdate(Request $request, $identity, $classId)
  {

    $class = CourseClass::findOrFail($classId);

    foreach ($request->records ?? [] as $student) {

      Attendance::updateOrCreate(
        [
          'class_id'   => $class->id,
          'student_id' => $student['user_id'],
        ],
        [
          'status' => $student['status'],
          'attendance_date' => now(), // optional column
          'marked_by' =>  auth()->user()->id, // optional
        ]
      );
    }

    // $class->load('attendance.user');

    return redirect()->back()->with('success', 'Attendance saved successfully');
  }


  public function durationEdit($identity, $classId)
  {
    $class = CourseClass::findOrFail($classId);
    return view('company.courses.classes.duration',compact('class'));
  }

  public function durationUpdate(Request $request,$identity,  $classId)
  {

    $class = CourseClass::findOrFail($classId);

    $startedAt = Carbon::parse($request->actual_start);
    $endedAt   = Carbon::parse($request->actual_end);

    // actual conducted minutes
    $actualMinutes = $startedAt->diffInMinutes($endedAt);

    /*
      Planned class duration
      based on scheduled start_time and end_time
    */
    $plannedMinutes = 0;

    if ($class->start_time && $class->end_time) {
      $plannedMinutes =
        Carbon::parse($class->start_time)
        ->diffInMinutes(
          Carbon::parse($class->end_time)
        );
    }

    /*
      Extra minutes beyond planned duration
    */
    $extraMinutes = max(
      $actualMinutes - $plannedMinutes,
      0
    );

    $duration = ClassDuration::updateOrCreate(
      [
        'class_id' => $class->id
      ],
      [
        'course_id' => $class->course_id,

        'started_at' => $startedAt,

        'ended_at' => $endedAt,

        'duration' => $plannedMinutes,

        'actual_duration' => $actualMinutes,

        'extra_minutes' => $extraMinutes,

        'note' => $request->note,

        'verified_by' => auth()->user()->id,

        'verified_at' => now(),

        'teacher_id'  => $request->teacher_id ?? null,

        'status' => 'completed'
      ]
    );

    return back()->with('success', 'Attendance saved successfully');
  }
}
