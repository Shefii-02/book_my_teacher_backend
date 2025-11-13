<?php

use App\Models\Department;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

// if (!function_exists('getDepartments')) {
//     function getDepartments()
//     {
//         return Department::where('is_active', 1)
//             ->orderBy('name', 'asc')
//             ->get(['id', 'name','slug']);
//     }
// }

// if (!function_exists('getServices')) {
//     function getServices()
//     {
//         return Service::where('is_active', 1)
//             ->orderBy('title', 'asc')
//             ->get(['id', 'title','slug']);
//     }
// }





function accountStatus($teacher)
{

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

    if ($stageKey == 'verification process' || $stageKey == 'schedule interview') {
      $allow      = false;
    }

    Log::alert($stageKey);


    if (!$foundCurrent) {
      if ($stageKey === $currentStage) {
        $foundCurrent = true;

        // current stage logic
        switch ($statusKey) {
          case 'in progress':
            $stepStatus = "inProgress";
            $subtitle   = $accountMsg;
            // $allow      = true;
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
            // $allow      = true;
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
  Log::info($steps);
  return [
    'accountMsg' => $accountMsg,
    'steps' => $steps,
  ];
}
