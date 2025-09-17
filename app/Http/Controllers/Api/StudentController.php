<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
  public function home(Request $request)
  {

    $studentId = $request->input('student_id'); // frontend should send teacher_id

    $student = User::where('id', $studentId)
                  ->where('acc_type', 'student')
                  ->where('company_id', 1)
                  ->first();

    if (!$student) {
      return response()->json([
        'message' => 'Student not found'
      ], 404);
    }


    // ✅ Get avatar & CV from MediaFile
    $avatar = MediaFile::where('user_id', $studentId)
      ->where('file_type', 'avatar')
      ->first();

    // ✅ Steps data as real array, not string
    $steps = [
      [
        "title"    => "Personal Info",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/personal-info",
        "allow"    => true,
      ],
      [
        "title"    => "Study Details",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/study-details",
        "allow"    => true,
      ],
      [
        "title"    => "Verification Process",
        "subtitle" => "In Progress",
        "status"   => "inProgress",
        "route"    => "/verification",
        "allow"    => false,
      ],
    ];

    return response()->json([
      'user'             => $student,
      'avatar'           => $avatar ? asset('storage/' . $avatar->file_path) : null,
      'steps'            => $steps,
    ]);
  }

}
