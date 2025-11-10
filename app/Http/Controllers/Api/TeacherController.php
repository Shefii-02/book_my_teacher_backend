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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    $teacherId = $request->user();

    $teacher = User::where('id', $teacherId->id)
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
    // $avatar = \App\Models\MediaFile::where('user_id', $teacherId)
    //   ->where('file_type', 'avatar')
    //   ->latest('id')
    //   ->first();

    $cvFile = \App\Models\MediaFile::where('user_id', $teacherId)
      ->where('file_type', 'cv')
      ->latest('id')
      ->first();

    // $stageList = [
    //   "personal information" => [
    //     "title" => "Personal Info",
    //     "route" => "/personal-info",
    //   ],
    //   "teaching information" => [
    //     "title" => "Teaching Details",
    //     "route" => "/teaching-details",
    //   ],
    //   "cv upload" => [
    //     "title" => "CV Upload",
    //     "route" => "/cv-upload",
    //   ],
    //   "verification process" => [
    //     "title" => "Verification Process",
    //     "route" => "/verification",
    //   ],
    //   "schedule interview" => [
    //     "title" => "Schedule Interview",
    //     "route" => "/schedule-interview",
    //   ],
    //   "upload demo class" => [
    //     "title" => "Upload Demo Class",
    //     "route" => "/upload-demo",
    //   ],
    // ];

    // $currentStage  = strtolower($teacher->current_account_stage ?? 'personal information');
    // $currentStatus = strtolower($teacher->account_status ?? 'in progress');
    // $accountMsg    = $teacher->account_msg;

    // // normalize status
    // if (strpos($currentStatus, 'scheduled') !== false) {
    //   $statusKey = 'scheduled';
    // } elseif (strpos($currentStatus, 'completed') !== false) {
    //   $statusKey = 'completed';
    // } elseif (strpos($currentStatus, 'reject') !== false) {
    //   $statusKey = 'rejected';
    // } else {
    //   $statusKey = 'in progress';
    // }

    // // default message
    // if (empty(trim($accountMsg))) {
    //   switch ($statusKey) {
    //     case 'rejected':
    //       $accountMsg = 'Your application was rejected. Please review feedback and resubmit.';
    //       break;
    //     case 'scheduled':
    //       $accountMsg = 'Your interview scheduled for 01/10/2025 10 AM please join on the time.if you not availabe please contact our team and reschedule.';
    //       break;
    //     default:
    //       $accountMsg = 'Your application is in progress. We will notify you of the next step.';
    //       break;
    //   }
    // }

    // // build stepper array
    // $steps = [];
    // $foundCurrent = false;

    // foreach ($stageList as $stageKey => $meta) {
    //   $stepStatus = "completed";
    //   $subtitle   = "Completed";
    //   $allow      = false;

    //   if (!$foundCurrent) {
    //     if ($stageKey === $currentStage) {
    //       $foundCurrent = true;

    //       // current stage logic
    //       switch ($statusKey) {
    //         case 'in progress':
    //           $stepStatus = "inProgress";
    //           if ($currentStage == 'schedule interview') {
    //             $subtitle   = "our team will you can please choose available time";
    //           } else {
    //             $subtitle   =  $accountMsg;
    //           }
    //           break;
    //         case 'rejected':
    //           $stepStatus = "rejected";
    //           if ($currentStage == 'schedule interview') {
    //             $subtitle   = "Your are rejected for interview our not statisfied your performance. Please stay on our community increase your career growth quality.";
    //           } elseif ($currentStage == 'verification process') {
    //             $subtitle = 'Your application was rejected. Common reasons: profile picture not professional or CV issues. Please update the requested fields and contact the team with screenshots for help.';
    //           } else {
    //             $subtitle   = $accountMsg;
    //           }
    //           $allow      = false;
    //           break;
    //         case 'scheduled':
    //           $stepStatus = "scheduled";
    //           $subtitle   = $accountMsg;
    //           break;
    //         case 'completed':
    //           $stepStatus = "completed";
    //           $subtitle   = "Completed";
    //           break;
    //       }
    //     }
    //   } else {
    //     // stages after current one → pending
    //     $stepStatus = "pending";
    //     $subtitle   = "Pending";
    //   }

    //   $steps[] = [
    //     'title'    => $meta['title'],
    //     'route'    => $meta['route'],
    //     'status'   => $stepStatus,
    //     'subtitle' => $subtitle,
    //     'allow'    => $allow,
    //   ];
    // }


    $stageList = [
      "personal information" => [
        "title" => "Personal Info",
        "route" => "/personal-info",
      ],
      "teaching information" => [
        "title" => "Teaching Details",
        "route" => "/teaching-details",
      ],
      "cv upload" => [
        "title" => "CV Upload",
        "route" => "/cv-upload",
      ],
      "verification process" => [
        "title" => "Verification Process",
        "route" => "/verification",
      ],
      "schedule interview" => [
        "title" => "Schedule Interview",
        "route" => "/schedule-interview",
      ],
      "upload demo class" => [
        "title" => "Upload Demo Class",
        "route" => "/upload-demo",
      ],
    ];

    // pull teacher status
    $currentStage  = strtolower($teacher->current_account_stage ?? 'personal information');
    $currentStatus = strtolower($teacher->account_status ?? 'in progress');
    $accountMsg    = $teacher->account_msg;

    // normalize status
    if (strpos($currentStatus, 'scheduled') !== false) {
      $statusKey = 'scheduled';
    } elseif (strpos($currentStatus, 'completed') !== false) {
      $statusKey = 'completed';
    } elseif (strpos($currentStatus, 'reject') !== false) {
      $statusKey = 'rejected';
    } else {
      $statusKey = 'in progress';
    }

    // interview datetime (from DB column interview_at)
    $interviewDateTime = $teacher->interview_at ?? null;
    $formattedDateTime = $interviewDateTime
      ? Carbon::parse($interviewDateTime)->format('d M Y, h:i A')
      : null;


    // default message if none stored
    if (empty(trim($accountMsg))) {
      switch ($statusKey) {
        case 'rejected':
          $accountMsg = 'Your application has been rejected. Please review the feedback carefully and update your details before resubmitting.';
          break;
        case 'scheduled':
          $accountMsg = $formattedDateTime
            ? "Your interview is scheduled for {$formattedDateTime}. Please join on time. If you are unavailable, kindly contact our team to reschedule."
            : "Your interview has been scheduled. Please check your dashboard for details.";
          break;
        case 'completed':
          $accountMsg = '';
          break;
        default:
          $accountMsg = 'Your application is in progress. We will notify you once the next step is available.';
          break;
      }
    }

    // build stepper array
    $steps = [];
    $foundCurrent = false;

    foreach ($stageList as $stageKey => $meta) {
      $stepStatus = "completed";
      $subtitle   = "Completed";
      $allow      = true;

      if (!$foundCurrent) {
        if ($stageKey === $currentStage) {
          $foundCurrent = true;

          // current stage logic
          switch ($statusKey) {
            case 'in progress':
              $stepStatus = "inProgress";
              $subtitle   = $accountMsg;
              $allow      = true;
              break;

            case 'rejected':
              $stepStatus = "rejected";
              // $subtitle   = $accountMsg;
              $stepStatus = "rejected";

              if ($currentStage == 'schedule interview') {
                $subtitle = "Unfortunately, you were not selected after the interview. We encourage you to stay active in our community and continue improving your skills for future opportunities.";
              } elseif ($currentStage == 'verification process') {
                $subtitle = "Your application was rejected during verification. Common reasons include a non-professional profile picture or CV formatting issues. Please update the required details and contact our team for guidance.";
              } elseif ($currentStage == 'upload demo class') {
                $subtitle = "Your demo class submission did not meet the required standards. Please review the feedback provided and upload an improved version.";
              } else {
                $subtitle = $accountMsg ?: "Your application was rejected. Please check the feedback and update your details before resubmitting.";
              }
              $allow      = true;
              break;

            case 'scheduled':
              $stepStatus = "scheduled";
              $subtitle   = $accountMsg;
              break;

            case 'completed':
              $stepStatus = "completed";
              $subtitle   = "Completed";
              break;
          }
        }
      } else {
        // stages after current one → pending
        $stepStatus = "pending";
        $subtitle   = "Pending";
        $allow      = false;
      }

      $steps[] = [
        'title'    => $meta['title'],
        'route'    => $meta['route'],
        'status'   => $stepStatus,
        'subtitle' => $subtitle,
        'allow'    => $allow,
      ];
    }


    // Verification step
    // $verificationCompleted = $verificationDone;
    // $steps[] = $makeStep(3, 'Verification Process', '/verification',     $verificationCompleted, $currentIndex, $rejectedIndex, false);
    // // Schedule Interview
    // $steps[] = $makeStep(4, 'Schedule Interview',   '/schedule-interview', $readyForInterview, $currentIndex, $rejectedIndex, false);
    // // Upload Demo
    // $demoAllowed = $readyForInterview || $isVerified;
    // $demoCompleted = $isVerified; // consider verified as demo step completed
    // $steps[] = $makeStep(5, 'Upload Demo Class',    '/upload-demo',      $demoCompleted,     $currentIndex, $rejectedIndex, false);




    // Determine which steps are completed based on present data
    // $personalCompleted  = !empty($teacher->name) && !empty($teacher->email);
    // $teachingCompleted  = (bool) $profInfo || ($subjects->count() > 0) || ($grades->count() > 0) || ($workingDays->count() > 0);
    // $cvCompleted        = (bool) $cvFile;
    // Verification depends on account status; schedule interview and demo depend on readiness/verification.
    // $verificationDone   = ($statusKey === 'verified' || $statusKey === 'ready_for_interview');
    // $readyForInterview  = ($statusKey === 'ready_for_interview');
    // $isVerified         = ($statusKey === 'verified');
    // $isRejected         = ($statusKey === 'rejected');

    // // If rejected, try to detect the failed step from the message
    // $rejectionReasonText = strtolower($accountMsg);
    // $rejectedIndex = null;
    // if ($isRejected) {
    //   if (strpos($rejectionReasonText, 'profile') !== false || strpos($rejectionReasonText, 'picture') !== false || strpos($rejectionReasonText, 'avatar') !== false) {
    //     $rejectedIndex = 0; // Personal Info
    //   } elseif (strpos($rejectionReasonText, 'teaching') !== false || strpos($rejectionReasonText, 'subject') !== false) {
    //     $rejectedIndex = 1; // Teaching Details
    //   } elseif (strpos($rejectionReasonText, 'cv') !== false || strpos($rejectionReasonText, 'resume') !== false) {
    //     $rejectedIndex = 2; // CV Upload
    //   } elseif (strpos($rejectionReasonText, 'interview') !== false) {
    //     $rejectedIndex = 4; // Schedule Interview
    //   } elseif (strpos($rejectionReasonText, 'demo') !== false) {
    //     $rejectedIndex = 5; // Upload Demo
    //   } else {
    //     $rejectedIndex = 3; // Verification step fallback
    //   }
    // }

    // Helper to build step item
    // $makeStep = function ($idx, $title, $route, $completed, $currentIndex, $rejectedIndex, $allowByDefault = false) use ($accountMsg) {
    //   $isRejected = ($rejectedIndex !== null && $rejectedIndex === $idx);
    //   if ($isRejected) {
    //     $status = 'rejected';
    //     $subtitle = 'Rejected';
    //   } elseif ($completed) {
    //     $status = 'completed';
    //     $subtitle = 'Completed';
    //   } elseif ($currentIndex !== null && $currentIndex === $idx) {
    //     $status = 'inProgress';
    //     $subtitle = 'In Progress';
    //   } else {
    //     $status = 'pending';
    //     $subtitle = 'Pending';
    //   }

    //   // If rejected give short reason as subtitle (truncate)
    //   if ($isRejected) {
    //     $short = strlen($accountMsg) > 120 ? substr($accountMsg, 0, 117) . '...' : $accountMsg;
    //     $subtitle = 'Rejected: ' . $short;
    //   }

    //   return [
    //     'title'    => $title,
    //     'subtitle' => $subtitle,
    //     'status'   => $status,
    //     'route'    => $route,
    //     'allow'    => (bool) $allowByDefault || $isRejected, // allow edits by default for that step or if it's rejected
    //   ];
    // };

    // Decide which step is current (index):
    // - For 'ready_for_interview' -> schedule interview (index 4)
    // - For 'verified' -> no current step (null)
    // - For 'rejected' -> the rejectedIndex
    // - For 'in_progress' -> first incomplete step
    // $currentIndex = null;
    // if ($isRejected) {
    //   $currentIndex = $rejectedIndex;
    // } elseif ($readyForInterview) {
    //   $currentIndex = 4;
    // } elseif ($isVerified) {
    //   $currentIndex = null;
    // } else { // in_progress or unknown -> first incomplete
    //   if (!$personalCompleted) {
    //     $currentIndex = 0;
    //   } elseif (!$teachingCompleted) {
    //     $currentIndex = 1;
    //   } elseif (!$cvCompleted) {
    //     $currentIndex = 2;
    //   } else {
    //     // if all three are present but verification not ready, mark verification as current
    //     $currentIndex = 3;
    //   }
    // }

    // Build steps
    // $steps = [];
    // $steps[] = $makeStep(0, 'Personal Info',        '/personal-info',    $personalCompleted, $currentIndex, $rejectedIndex, false);
    // $steps[] = $makeStep(1, 'Teaching Details',     '/teaching-details', $teachingCompleted, $currentIndex, $rejectedIndex, false);
    // $steps[] = $makeStep(2, 'CV Upload',            '/cv-upload',        $cvCompleted,       $currentIndex, $rejectedIndex, false);
    // // Verification step
    // $verificationCompleted = $verificationDone;
    // $steps[] = $makeStep(3, 'Verification Process', '/verification',     $verificationCompleted, $currentIndex, $rejectedIndex, false);
    // // Schedule Interview
    // $steps[] = $makeStep(4, 'Schedule Interview',   '/schedule-interview', $readyForInterview, $currentIndex, $rejectedIndex, false);
    // // Upload Demo
    // $demoAllowed = $readyForInterview || $isVerified;
    // $demoCompleted = $isVerified; // consider verified as demo step completed
    // $steps[] = $makeStep(5, 'Upload Demo Class',    '/upload-demo',      $demoCompleted,     $currentIndex, $rejectedIndex, false);

    return response()->json([
      'user'              => $teacher,
      'professional_info' => $profInfo,
      'working_days'      => $workingDays,
      'working_hours'     => $workingHours,
      'grades'            => $grades,
      'subjects'          => $subjects,
      'avatar'            => $teacher->avatar ? asset('storage/' . $teacher->avatar->file_path) : null,
      'cv_file'           => $teacher ? asset('storage/' . $teacher->cv->file_path) : null,
      'account_status'    => $teacher->account_status,
      'account_msg'       => $accountMsg,
      'steps'             => $steps,
    ]);
  }



  public function teacherUpdatePersonal(Request $request)
  {

    DB::beginTransaction();
    $company_id = 1;
    $teacher = $request->user();
    $teacher_id = $teacher->id;
    Log::info($request->all());


    $user = User::where('id', $teacher_id)->where('company_id', $company_id)->first();
    Log::info($user);

    try {
      if ($user) {
        // 1️⃣ Create or Update User
        User::where('id', $teacher_id)
          ->update(
            [
              'name'        => $request->name,
              'email'       => $request->email,
              'address'     => $request->address,
              'city'        => $request->city,
              'postal_code' => $request->postal_code,
              'district'    => $request->district,
              'state'       => $request->state,
              'country'     => $request->country,
            ]
          );

        // 7️⃣ Media Files (Avatar + CV)
        if ($request->hasFile('avatar')) {

          // Delete physical file
          $userAvatarPath = $user->avatar ? $user->avatar->file_path : null;

          if ($userAvatarPath && Storage::disk('public')->exists($userAvatarPath)) {
            Storage::disk('public')->delete($userAvatarPath);
          }

          MediaFile::where('company_id', $company_id)->where('user_id', $user->id)->where('file_type', 'avatar')->delete();
          $file = $request->file('avatar');
          $path = $file->storeAs(
            'uploads/avatars',
            time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
            'public'
          );

          MediaFile::create([
            'user_id' => $user->id,
            'company_id' => $company_id,
            'file_type'  => 'avatar',
            'file_path'  => $path,
            'name'       => $file->getClientOriginalName(),
            'mime_type'  => $file->getMimeType(),
          ]);
        }

        $user->save();
        DB::commit();
        $user->refresh();
        Log::info($user);

        return response()->json([
          'status'            => true,
          'message'           => 'Teacher updated successfully'
        ], 201);
      } else {
        DB::rollBack();
        return response()->json([
          'status'            => false,
          'message' => 'Teacher updation failed',
          'error'   => "User not found",
        ], 500);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Teacher updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }
  public function teacherUpdateTeachingDetail(Request $request)
  {
    $user = $request->user();

    try {
      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = TeacherProfessionalInfo::updateOrCreate(
        ['teacher_id' => $user->id],
        [
          'profession'    => $request->profession,
          'ready_to_work' => $request->ready_to_work,
          'teaching_mode'    => $request->interest,
          'offline_exp'   => $request->offline_exp,
          'online_exp'    => $request->online_exp,
          'home_exp'      => $request->home_exp,
        ]
      );

      // 3️⃣ Sync Working Days
      if ($request->filled('working_days')) {
        TeacherWorkingDay::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->working_days) as $day) {
          TeacherWorkingDay::create([
            'teacher_id' => $user->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('working_hours')) {
        TeacherWorkingHour::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->working_hours) as $hour) {
          TeacherWorkingHour::create([
            'teacher_id' => $user->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('teaching_grades')) {
        TeacherGrade::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->teaching_grades) as $grade) {
          TeacherGrade::create([
            'teacher_id' => $user->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($request->filled('teaching_subjects')) {
        TeachingSubject::where('teacher_id', $user->id)->delete();
        foreach (explode(',', $request->teaching_subjects) as $subject) {
          TeachingSubject::create([
            'teacher_id' => $user->id,
            'subject'    => trim($subject),
          ]);
        }
      }

      $user->save();
      DB::commit();
      $user->refresh();
      Log::info($user);

      return response()->json([
        'status'            => true,
        'message'           => 'Teacher updated successfully'
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Teacher updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }

  public function teacherUpdateCv(Request $request)
  {
    $user = $request->user();
    $company_id = 1;
    try {
      if ($request->hasFile('cv_file')) {
        // Delete physical file
        $userCvPath = $user->cv ? $user->cv->file_path : null;

        if ($userCvPath && Storage::disk('public')->exists($userCvPath)) {
          Storage::disk('public')->delete($userCvPath);
        }

        MediaFile::where('company_id', $company_id)->where('user_id', $user->id)->where('file_type', 'cv')->delete();
        $file = $request->file('cv_file');
        $cvPath = $file->storeAs(
          'uploads/cv_files',
          time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
          'public'
        );

        MediaFile::create([
          'user_id' => $user->id,
          'company_id' => $company_id,
          'file_type'  => 'cv', // ✅ FIXED
          'file_path'  => $cvPath, // ✅ FIXED
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);
      }
      $user->save();
      DB::commit();
      $user->refresh();
      Log::info($user);

      return response()->json([
        'status'            => true,
        'message'           => 'Teacher updated successfully'
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Teacher updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }
}
