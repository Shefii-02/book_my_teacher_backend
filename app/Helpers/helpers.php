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


if (!function_exists('implodeComma')) {

    function implodeComma($data)
    {
        if ($data instanceof \Illuminate\Support\Collection) {
            $data = $data->toArray();
        }

        return is_array($data) ? implode(', ', $data) : '';
    }
}


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

  return [
    'accountMsg' => $accountMsg,
    'steps' => $steps,
  ];
}



function getPrice($price)
{
  return '₹' . $price;
}




if (!function_exists('shorten_price')) {
  function shorten_price($price)
  {
    if ($price >= 10000000) {
      return '₹' . indian_number_format($price / 10000000, 2) . ' Cr';
    } elseif ($price >= 100000) {
      return '₹' . indian_number_format($price / 100000, 2) . ' L';
    } elseif ($price >= 1000) {
      return '₹' . indian_number_format($price / 1000, 2) . ' K';
    } else {
      return '₹' . indian_number_format($price, 2);
    }
  }
}

// if (! function_exists('human_price_text')) {
//     function human_price_text(float|null|string $price, string|null $priceUnit = '', bool $fullNumber = false): string
//     {
//         $numberAfterDot = ($currency instanceof Currency) ? $currency->decimals : 0;

//         if (! $fullNumber) {
//             if ($price >= 1000000 && $price < 1000000000) {
//                 $price = round($price / 1000000, 2) + 0;
//                 $priceUnit = __('Million') . ' ' . $priceUnit;
//                 $numberAfterDot = strlen(substr(strrchr((string)$price, '.'), 1));
//             } elseif ($price >= 1000000000) {
//                 $price = round($price / 1000000000, 2) + 0;
//                 $priceUnit = __('Billion') . ' ' . $priceUnit;
//                 $numberAfterDot = strlen(substr(strrchr((string)$price, '.'), 1));
//             }
//         }

//         if (is_numeric($price)) {
//             $price = preg_replace('/[^0-9,.]/s', '', (string)$price);
//         }

//         $decimalSeparator = setting('real_estate_decimal_separator', '.');

//         if ($decimalSeparator == 'space') {
//             $decimalSeparator = ' ';
//         }

//         $thousandSeparator = setting('real_estate_thousands_separator', ',');

//         if ($thousandSeparator == 'space') {
//             $thousandSeparator = ' ';
//         }

//         $price = indian_number_format(
//             (float)$price,
//             (int)$numberAfterDot,
//             $decimalSeparator,
//             $thousandSeparator
//         );

//         $space = setting('real_estate_add_space_between_price_and_currency', 0) == 1 ? ' ' : null;

//         return $price . $space . ($priceUnit ?: '');
//     }
// }



if (!function_exists('dateTimeFormat')) {

  function dateTimeFormat($date)
  {
    $date = date('d M,Y', strtotime($date));
    $time = date('h:i a', strtotime($date));
    return  $date . ',' . $time;
  }
}

if (!function_exists('dateFormat')) {

  function dateFormat($date)
  {
    $date = date('d M,Y', strtotime($date));
    return  $date;
  }
}

if (!function_exists('TimeFormat')) {

  function TimeFormat($date)
  {
    $time = date('h:i a', strtotime($date));
    return  $time;
  }
}


function indian_number_format($number)
{
  $decimal = ''; // To store decimal part if needed
  if (strpos($number, '.') !== false) {
    [$number, $decimal] = explode('.', $number); // Split integer and decimal parts
    $decimal = '.' . $decimal; // Reattach decimal point
  }

  // Convert the number to a string and reverse it
  $number = strrev($number);

  // Insert commas after the first 3 digits, then every 2 digits
  $formatted = preg_replace('/(\d{3})(?=\d)/', '$1,', $number);
  $formatted = preg_replace('/(\d{2})(?=(\d{2},)+\d)/', '$1,', $formatted);

  // Reverse the string back to normal
  $formatted = strrev($formatted);

  // Reattach decimal part if present
  return $formatted . $decimal;
}

function numberToWords($number)
{
  $units = [
    0 => '',
    1 => 'one',
    2 => 'two',
    3 => 'three',
    4 => 'four',
    5 => 'five',
    6 => 'six',
    7 => 'seven',
    8 => 'eight',
    9 => 'nine',
    10 => 'ten',
    11 => 'eleven',
    12 => 'twelve',
    13 => 'thirteen',
    14 => 'fourteen',
    15 => 'fifteen',
    16 => 'sixteen',
    17 => 'seventeen',
    18 => 'eighteen',
    19 => 'nineteen'
  ];
  $tens = [
    20 => 'twenty',
    30 => 'thirty',
    40 => 'forty',
    50 => 'fifty',
    60 => 'sixty',
    70 => 'seventy',
    80 => 'eighty',
    90 => 'ninety'
  ];
  $scales = [
    100 => 'hundred',
    1000 => 'thousand',
    1000000 => 'million',
    1000000000 => 'billion'
  ];
  $result = [];
  if ($number == 0) {
    return 'zero';
  }
  while ($number > 0) {
    $scale = 1;
    foreach ($scales as $multiplier => $scaleName) {
      if ($number >= $multiplier) {
        $scale = $multiplier;
      }
    }
    $scaleName = $scales[$scale] ?? '';
    if ($scaleName) {
      $result[] = numberToWords($number / $scale) . ' ' . $scaleName;
      $number %= $scale;
    } elseif ($number < 20) {
      $result[] = $units[$number];
      $number = 0;
    } elseif ($number < 100) {
      $ten = floor($number / 10) * 10;
      $unit = $number % 10;
      $result[] = ($tens[$ten] ?? '') . ($unit ? ' ' . $units[$unit] : '');
      $number = 0;
    } else {
      $result[] = numberToWords($number / 100) . ' hundred';
      $number %= 100;
    }
  }
  return implode(' ', array_reverse($result));
}
