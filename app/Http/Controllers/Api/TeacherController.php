<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TeacherGrade;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeacherWorkingDay;
use App\Models\TeacherWorkingHour;
use App\Models\TeachingSubject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class TeacherController extends Controller
{

  public function home(Request $request)
  {

    $teacherId = $request->input('teacher_id'); // frontend should send teacher_id

    $teacher = User::where('id', $teacherId)
      ->where('acc_type', 'teacher')
      ->where('company_id', 1)
      ->first();

    if (!$teacher) {
      return response()->json([
        'message' => 'Teacher not found'
      ], 404);
    }

    // ✅ Collect related info
    $profInfo = TeacherProfessionalInfo::where('teacher_id', $teacherId)->first();
    $workingDays = TeacherWorkingDay::where('teacher_id', $teacherId)->pluck('day');
    $workingHours = TeacherWorkingHour::where('teacher_id', $teacherId)->pluck('time_slot');
    $grades = TeacherGrade::where('teacher_id', $teacherId)->pluck('grade');
    $subjects = TeachingSubject::where('teacher_id', $teacherId)->pluck('subject');

    // ✅ Get avatar & CV from MediaFile
    $avatar = MediaFile::where('user_id', $teacherId)->where('file_type', 'avatar')->first();
    $cvFile = MediaFile::where('user_id', $teacherId)->where('file_type', 'cv')->first();

    return response()->json([
      'user' => $teacher,
      'professional_info' => $profInfo,
      'working_days' => $workingDays,
      'working_hours' => $workingHours,
      'grades' => $grades,
      'subjects' => $subjects,
      'avatar' => $avatar ? asset('storage/' . $avatar->file_path) : null,
      'cv_file' => $cvFile ? asset('storage/' . $cvFile->file_path) : null,
    ]);
  }
}
