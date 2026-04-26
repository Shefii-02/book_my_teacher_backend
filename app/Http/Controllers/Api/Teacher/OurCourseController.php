<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\ClassLinkResource;
use App\Http\Resources\API\CourseClassLinkResource;
use App\Http\Resources\API\CourseResource;
use App\Http\Resources\API\MaterialResource;
use App\Http\Resources\API\WebinarClassLinkResource;
use App\Http\Resources\API\WorkshopResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WebinarResource;
use App\Models\Attendance;
use App\Models\ClassDuration;
use App\Models\CompanyTeacher;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseMaterial;
use App\Models\DemoClass;
use App\Models\MediaFile;
use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Models\TeacherGrade;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeacherWorkingDay;
use App\Models\TeacherWorkingHour;
use App\Models\TeachingSubject;
use App\Models\User;
use App\Models\Webinar;
use App\Models\Workshop;
use App\Models\WorkshopClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Dom\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class OurCourseController extends Controller
{

  public function studentsAttendance(Request $request, $classId)
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
          "student_id" => $item->student_id,
          "name" => $item->user->name ?? '',
          "roll_number" => $item->user->roll_number ?? '',
          "initials" => $this->getInitials($item->user->name ?? ''),
          "avatar_color" => "#4A47B0",
          "attendance_status" => $item->status ?? "none",
        ];
      });

      return response()->json([
        'success' => true,
        'students' => $students
      ]);
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
        "student_id" => $item->student_id,
        "name" => $item->user->name ?? '',
        "roll_number" => $item->user->roll_number ?? '',
        "initials" => $this->getInitials($item->user->name ?? ''),
        "avatar_color" => "#4A47B0",
        "attendance_status" => $item->status ?? "none",
      ];
    });

    Log::info($students);

    return response()->json([
      'success' => true,
      'students' => $students
    ]);
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

  // public function studentsAttendance(Request $request, $classId)
  // {

  //   $class = CourseClass::with('')->where('id',$classId)->first();

  //   $students = collect([
  //     // [
  //     //   "student_id" => 1,
  //     //   "name" => "Arjun Kumar",
  //     //   "roll_number" => "STU-001",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#4A47B0",
  //     //   "attendance_status" => "present",
  //     // ],
  //     // [
  //     //   "student_id" => 2,
  //     //   "name" => "Rahul Nair",
  //     //   "roll_number" => "STU-002",
  //     //   "initials" => "RN",
  //     //   "avatar_color" => "#FF6B6B",
  //     //   "attendance_status" => "absent",
  //     // ],
  //     // [
  //     //   "student_id" => 3,
  //     //   "name" => "Sneha Das",
  //     //   "roll_number" => "STU-003",
  //     //   "initials" => "SD",
  //     //   "avatar_color" => "#00B894",
  //     //   "attendance_status" => "late",
  //     // ],
  //     // [
  //     //   "student_id" => 4,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 5,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 6,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 7,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 8,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 9,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 10,
  //     //   "name" => "Arjun Kumar",
  //     //   "roll_number" => "STU-001",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#4A47B0",
  //     //   "attendance_status" => "present",
  //     // ],

  //     // [
  //     //   "student_id" => 11,
  //     //   "name" => "Arjun Kumar",
  //     //   "roll_number" => "STU-001",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#4A47B0",
  //     //   "attendance_status" => "present",
  //     // ],
  //     // [
  //     //   "student_id" => 12,
  //     //   "name" => "Rahul Nair",
  //     //   "roll_number" => "STU-002",
  //     //   "initials" => "RN",
  //     //   "avatar_color" => "#FF6B6B",
  //     //   "attendance_status" => "absent",
  //     // ],
  //     // [
  //     //   "student_id" => 13,
  //     //   "name" => "Sneha Das",
  //     //   "roll_number" => "STU-003",
  //     //   "initials" => "SD",
  //     //   "avatar_color" => "#00B894",
  //     //   "attendance_status" => "late",
  //     // ],
  //     // [
  //     //   "student_id" => 14,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 15,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 16,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 17,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 18,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //     // [
  //     //   "student_id" => 19,
  //     //   "name" => "Aman Khan",
  //     //   "roll_number" => "STU-004",
  //     //   "initials" => "AK",
  //     //   "avatar_color" => "#0984E3",
  //     //   "attendance_status" => null, // not marked yet
  //     // ],
  //   ]);

  //   return response()->json([
  //     "students" => $students
  //   ]);
  // }


  public function saveAttendance(Request $request, $classId)
  {

    $user = $request->user();
    // $request->validate([
    //     'students' => 'required|array',
    //     'students.*.student_id' => 'required|exists:users,id',
    //     'students.*.attendance_status' => 'required|in:present,absent,late,pending',
    // ]);



    $class = CourseClass::findOrFail($classId);

    foreach ($request->records ?? [] as $student) {

      Attendance::updateOrCreate(
        [
          'class_id'   => $class->id,
          'student_id' => $student['student_id'],
        ],
        [
          'status' => $student['status'],
          'attendance_date' => now(), // optional column
          'marked_by' => $user->id, // optional
        ]
      );
    }

    $class->load('attendance.user');

    $students = $class->attendance->map(function ($item) {

      return [
        "student_id" => $item->student_id,
        "name" => $item->user->name ?? '',
        "attendance_status" => $item->status
      ];
    });

    return response()->json([
      'success' => true,
      'message' => 'Attendance saved successfully',
      'students' => $students
    ]);
  }
  public function updateClassDuration(Request $request, $classId)
  {

    $user = $request->user();

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

        'verified_by' => $user->id,
        'verified_at' => now(),

        'status' => 'completed'
      ]
    );


    return response()->json([
      'success' => true,
      'message' => 'Class duration updated',
      'data' => $duration
    ]);
  }
}
