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

  // public function home(Request $request)
  // {

  //   $teacherId = $request->input('teacher_id'); // frontend should send teacher_id

  //   $teacher = User::where('id', $teacherId)
  //     ->where('acc_type', 'teacher')
  //     ->where('company_id', 1)
  //     ->first();

  //   if (!$teacher) {
  //     return response()->json([
  //       'message' => 'Teacher not found'
  //     ], 404);
  //   }

  //   // ✅ Collect related info
  //   $profInfo     = TeacherProfessionalInfo::where('teacher_id', $teacherId)->first();
  //   $workingDays  = TeacherWorkingDay::where('teacher_id', $teacherId)->pluck('day');
  //   $workingHours = TeacherWorkingHour::where('teacher_id', $teacherId)->pluck('time_slot');
  //   $grades       = TeacherGrade::where('teacher_id', $teacherId)->pluck('grade');
  //   $subjects     = TeachingSubject::where('teacher_id', $teacherId)->pluck('subject');

  //   // ✅ Get avatar & CV from MediaFile
  //   $avatar = MediaFile::where('user_id', $teacherId)
  //     ->where('file_type', 'avatar')
  //     ->first();

  //   $cvFile = MediaFile::where('user_id', $teacherId)
  //     ->where('file_type', 'cv')
  //     ->first();

  //   // ✅ Steps data as real array, not string
  //   $steps = [
  //     [
  //       "title"    => "Personal Info",
  //       "subtitle" => "Completed",
  //       "status"   => "completed",
  //       "route"    => "/personal-info",
  //       "allow"    => false,
  //     ],
  //     [
  //       "title"    => "Teaching Details",
  //       "subtitle" => "Completed",
  //       "status"   => "completed",
  //       "route"    => "/teaching-details",
  //       "allow"    => false,
  //     ],
  //     [
  //       "title"    => "CV Upload",
  //       "subtitle" => "Completed",
  //       "status"   => "completed",
  //       "route"    => "/cv-upload",
  //       "allow"    => false,
  //     ],
  //     [
  //       "title"    => "Verification Process",
  //       "subtitle" => "In Progress",
  //       "status"   => "inProgress",
  //       "route"    => "/verification",
  //       "allow"    => false,
  //     ],
  //     [
  //       "title"  => "Schedule Interview",
  //       "status" => "pending",
  //       "route"  => "/schedule-interview",
  //       "allow"  => false,
  //     ],
  //     [
  //       "title"  => "Upload Demo Class",
  //       "status" => "pending",
  //       "route"  => "/upload-demo",
  //       "allow"  => false,
  //     ],
  //   ];

  //   return response()->json([
  //     'user'             => $teacher,
  //     'professional_info' => $profInfo,
  //     'working_days'     => $workingDays,
  //     'working_hours'    => $workingHours,
  //     'grades'           => $grades,
  //     'subjects'         => $subjects,
  //     'avatar'           => $avatar ? asset('storage/' . $avatar->file_path) : null,
  //     'cv_file'          => $cvFile ? asset('storage/' . $cvFile->file_path) : null,
  //     'steps'            => $steps, // ✅ Proper JSON array
  //   ]);
  // }

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

    // Related info
    $profInfo     = \App\Models\TeacherProfessionalInfo::where('teacher_id', $teacherId)->first();
    $workingDays  = \App\Models\TeacherWorkingDay::where('teacher_id', $teacherId)->pluck('day');
    $workingHours = \App\Models\TeacherWorkingHour::where('teacher_id', $teacherId)->pluck('time_slot');
    $grades       = \App\Models\TeacherGrade::where('teacher_id', $teacherId)->pluck('grade');
    $subjects     = \App\Models\TeachingSubject::where('teacher_id', $teacherId)->pluck('subject');

    // Avatar & CV from MediaFile
    $avatar = \App\Models\MediaFile::where('user_id', $teacherId)
      ->where('file_type', 'avatar')
      ->latest('id')
      ->first();

    $cvFile = \App\Models\MediaFile::where('user_id', $teacherId)
      ->where('file_type', 'cv')
      ->latest('id')
      ->first();

    // Normalize account status
    $rawStatus = $teacher->account_status ?? 'In Progress';
    $lower     = strtolower(trim($rawStatus));

    if (strpos($lower, 'ready') !== false) {
      $statusKey = 'ready_for_interview';
    } elseif (strpos($lower, 'verified') !== false) {
      $statusKey = 'verified';
    } elseif (strpos($lower, 'reject') !== false || strpos($lower, 'rejected') !== false) {
      $statusKey = 'rejected';
    } else {
      $statusKey = 'in_progress';
    }

    // Account message (use DB value if present; otherwise sensible defaults)
    $accountMsg = $teacher->account_msg ?? null;
    if (empty(trim($accountMsg))) {
      switch ($statusKey) {
        case 'ready_for_interview':
          $accountMsg = 'Your application is ready for interview. Please schedule at a convenient time.';
          break;
        case 'verified':
          $accountMsg = 'Your application has been verified and approved.';
          break;
        case 'rejected':
          $accountMsg = 'Your application was rejected. Common reasons: profile picture not professional, CV format issues. Please update the requested fields and contact the team with screenshots for help.';
          break;
        default:
          $accountMsg = 'Your application is in progress. We will notify you when the next step is available.';
          break;
      }
    }

    // Determine which steps are completed based on present data
    $personalCompleted  = !empty($teacher->name) && !empty($teacher->email);
    $teachingCompleted  = (bool) $profInfo || ($subjects->count() > 0) || ($grades->count() > 0) || ($workingDays->count() > 0);
    $cvCompleted        = (bool) $cvFile;
    // Verification depends on account status; schedule interview and demo depend on readiness/verification.
    $verificationDone   = ($statusKey === 'verified' || $statusKey === 'ready_for_interview');
    $readyForInterview  = ($statusKey === 'ready_for_interview');
    $isVerified         = ($statusKey === 'verified');
    $isRejected         = ($statusKey === 'rejected');

    // If rejected, try to detect the failed step from the message
    $rejectionReasonText = strtolower($accountMsg);
    $rejectedIndex = null;
    if ($isRejected) {
      if (strpos($rejectionReasonText, 'profile') !== false || strpos($rejectionReasonText, 'picture') !== false || strpos($rejectionReasonText, 'avatar') !== false) {
        $rejectedIndex = 0; // Personal Info
      } elseif (strpos($rejectionReasonText, 'teaching') !== false || strpos($rejectionReasonText, 'subject') !== false) {
        $rejectedIndex = 1; // Teaching Details
      } elseif (strpos($rejectionReasonText, 'cv') !== false || strpos($rejectionReasonText, 'resume') !== false) {
        $rejectedIndex = 2; // CV Upload
      } elseif (strpos($rejectionReasonText, 'interview') !== false) {
        $rejectedIndex = 4; // Schedule Interview
      } elseif (strpos($rejectionReasonText, 'demo') !== false) {
        $rejectedIndex = 5; // Upload Demo
      } else {
        $rejectedIndex = 3; // Verification step fallback
      }
    }

    // Helper to build step item
    $makeStep = function ($idx, $title, $route, $completed, $currentIndex, $rejectedIndex, $allowByDefault = false) use ($accountMsg) {
      $isRejected = ($rejectedIndex !== null && $rejectedIndex === $idx);
      if ($isRejected) {
        $status = 'rejected';
        $subtitle = 'Rejected';
      } elseif ($completed) {
        $status = 'completed';
        $subtitle = 'Completed';
      } elseif ($currentIndex !== null && $currentIndex === $idx) {
        $status = 'inProgress';
        $subtitle = 'In Progress';
      } else {
        $status = 'pending';
        $subtitle = 'Pending';
      }

      // If rejected give short reason as subtitle (truncate)
      if ($isRejected) {
        $short = strlen($accountMsg) > 120 ? substr($accountMsg, 0, 117) . '...' : $accountMsg;
        $subtitle = 'Rejected: ' . $short;
      }

      return [
        'title'    => $title,
        'subtitle' => $subtitle,
        'status'   => $status,
        'route'    => $route,
        'allow'    => (bool) $allowByDefault || $isRejected, // allow edits by default for that step or if it's rejected
      ];
    };

    // Decide which step is current (index):
    // - For 'ready_for_interview' -> schedule interview (index 4)
    // - For 'verified' -> no current step (null)
    // - For 'rejected' -> the rejectedIndex
    // - For 'in_progress' -> first incomplete step
    $currentIndex = null;
    if ($isRejected) {
      $currentIndex = $rejectedIndex;
    } elseif ($readyForInterview) {
      $currentIndex = 4;
    } elseif ($isVerified) {
      $currentIndex = null;
    } else { // in_progress or unknown -> first incomplete
      if (!$personalCompleted) {
        $currentIndex = 0;
      } elseif (!$teachingCompleted) {
        $currentIndex = 1;
      } elseif (!$cvCompleted) {
        $currentIndex = 2;
      } else {
        // if all three are present but verification not ready, mark verification as current
        $currentIndex = 3;
      }
    }

    // Build steps
    $steps = [];
    $steps[] = $makeStep(0, 'Personal Info',        '/personal-info',    $personalCompleted, $currentIndex, $rejectedIndex, false);
    $steps[] = $makeStep(1, 'Teaching Details',     '/teaching-details', $teachingCompleted, $currentIndex, $rejectedIndex, false);
    $steps[] = $makeStep(2, 'CV Upload',            '/cv-upload',        $cvCompleted,       $currentIndex, $rejectedIndex, false);
    // Verification step
    $verificationCompleted = $verificationDone;
    $steps[] = $makeStep(3, 'Verification Process', '/verification',     $verificationCompleted, $currentIndex, $rejectedIndex, false);
    // Schedule Interview
    $steps[] = $makeStep(4, 'Schedule Interview',   '/schedule-interview', $readyForInterview, $currentIndex, $rejectedIndex, false);
    // Upload Demo
    $demoAllowed = $readyForInterview || $isVerified;
    $demoCompleted = $isVerified; // consider verified as demo step completed
    $steps[] = $makeStep(5, 'Upload Demo Class',    '/upload-demo',      $demoCompleted,     $currentIndex, $rejectedIndex, false);
    return response()->json([
      'user'              => $teacher,
      'professional_info' => $profInfo,
      'working_days'      => $workingDays,
      'working_hours'     => $workingHours,
      'grades'            => $grades,
      'subjects'          => $subjects,
      'avatar'            => $avatar ? asset('storage/' . $avatar->file_path) : null,
      'cv_file'           => $cvFile ? asset('storage/' . $cvFile->file_path) : null,
      'account_status'    => $teacher->account_status ?? $rawStatus,
      'account_msg'       => $accountMsg,
      'steps'             => $steps,
    ]);
  }
}
