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


class GuestController extends Controller
{

  public function home(Request $request)
  {

    $guestId = $request->input('guest_id');

    $guest = User::where('id', $guestId)
      ->where('acc_type', 'guest')
      ->where('company_id', 1)
      ->first();

    if (!$guest) {
      return response()->json([
        'message' => 'Guest Account not found'
      ], 404);
    }


    // ✅ Get avatar & CV from MediaFile
    $avatar = MediaFile::where('user_id', $guestId)
      ->where('file_type', 'avatar')
      ->first();

    $cvFile = MediaFile::where('user_id', $guestId)
      ->where('file_type', 'cv')
      ->first();

    // ✅ Steps data as real array, not string
    $steps = [
      [
        "title"    => "Personal Info",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/personal-info",
        "allow"    => false,
      ],
      [
        "title"    => "Teaching Details",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/teaching-details",
        "allow"    => false,
      ],
      [
        "title"    => "CV Upload",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/cv-upload",
        "allow"    => false,
      ],
      [
        "title"    => "Verification Process",
        "subtitle" => "In Progress",
        "status"   => "inProgress",
        "route"    => "/verification",
        "allow"    => false,
      ],
      [
        "title"  => "Schedule Interview",
        "status" => "pending",
        "route"  => "/schedule-interview",
        "allow"  => false,
      ],
      [
        "title"  => "Upload Demo Class",
        "status" => "pending",
        "route"  => "/upload-demo",
        "allow"  => false,
      ],
    ];

    return response()->json([
      'user'             => $guest,
      'avatar'           => $avatar ? asset('storage/' . $avatar->file_path) : null,
      'cv_file'          => $cvFile ? asset('storage/' . $cvFile->file_path) : null,
      'steps'            => $steps, // ✅ Proper JSON array
    ]);
  }
}
