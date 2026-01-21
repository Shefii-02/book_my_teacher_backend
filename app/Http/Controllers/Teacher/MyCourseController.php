<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Helpers\MediaHelper;
use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Models\Company;
use App\Models\Course;
use App\Models\MediaFile;
use App\Models\SubjectCourse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MyCourseController extends Controller
{
  public function index()
  {
    $user = User::where('id', auth()->user()->id)->first() ?? abort(404);
    $teacher = Teacher::where('user_id', $user->id)->first();

    $my_courses = Course::whereHas('teacherCourses', function ($q) use ($teacher) {
      $q->where('teacher_id', $teacher->id);
    })->get();


    $data['courses']['total'] = $my_courses->count();

    $data['on_going']['total'] = 0;

    $data['completed']['total'] = 0;

    $data['draft']['total'] = 0;

    return view('teacher.my_courses.index', compact('my_courses'));
  }

  public function show($course_id)
  {
    $user = User::where('id', auth()->user()->id)->first() ?? abort(404);
    $teacher = Teacher::where('user_id', $user->id)->first();
    $course = Course::whereHas('teacherCourses', function ($q) use ($teacher) {
      $q->where('teacher_id', $teacher->id);
    })->where('course_identity',$course_id)->first() ?? abort(404);
    return view('teacher.my_courses.show', compact('course'));

  }
}
