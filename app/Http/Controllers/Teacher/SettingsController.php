<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\MediaHelper;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompanyContact;
use App\Models\DeleteAccountRequest;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Log;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeacherWorkingDay;
use App\Models\TeachersTeachingGradeDetail;
use App\Models\TeacherWorkingHour;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
  public function index()
  {
    $user = auth()->user();

    /*
        |--------------------------------------------------------------------------
        | Teacher
        |--------------------------------------------------------------------------
        */
    $teacher = Teacher::where('user_id', $user->id)
      ->first();

    /*
        |--------------------------------------------------------------------------
        | Professional Info
        |--------------------------------------------------------------------------
        */
    $professional = TeacherProfessionalInfo::where('teacher_id', $teacher?->id)
      ->first();

    /*
        |--------------------------------------------------------------------------
        | Teaching Grades
        |--------------------------------------------------------------------------
        */
    $teachingGrades = TeachersTeachingGradeDetail::with([
      'grade',
      'board',
      'subject',
    ])
      ->where('user_id', $user->id)
      ->get();

    /*
        |--------------------------------------------------------------------------
        | Working Days & Hours
        |--------------------------------------------------------------------------
        */
    $workingDays = TeacherWorkingDay::with([
      'slots',
    ])
      ->where('teacher_id', $teacher?->id)
      ->get();

    /*
        |--------------------------------------------------------------------------
        | Dropdowns
        |--------------------------------------------------------------------------
        */
    $grades = Grade::orderBy('name')->get();

    $boards = Board::orderBy('name')->get();

    $subjects = Subject::orderBy('name')->get();

    return view(
      'teacher.settings.index',
      compact(
        'teacher',
        'professional',
        'teachingGrades',
        'workingDays',
        'grades',
        'boards',
        'subjects'
      )
    );
  }

  /*
    |--------------------------------------------------------------------------
    | PROFILE UPDATE
    |--------------------------------------------------------------------------
    */
  public function updateProfile(Request $request)
  {

    $user = auth()->user();

    $teacher = User::where('id', $user->id)->first();

    $teacher->update([
      'name'        => request('name'),
      'email'       => request('email'),
      'phone'       => request('phone'),
      'address'     => request('address'),
      'city'        => request('city'),
      'postal_code' => request('postal_code'),
      'district'    => request('district'),
      'state'       => request('state'),
      'country'     => request('country'),
    ]);

    return back()->with('success', 'Profile updated');
  }

  /*
    |--------------------------------------------------------------------------
    | PROFESSIONAL UPDATE
    |--------------------------------------------------------------------------
    */
  public function updateProfessional(Request $request)
  {
     $user = auth()->user();

        $data = TeacherProfessionalInfo::updateOrCreate(
            ['teacher_id' => $user->id],
            [
                'year_exp_offline' => request('year_exp_offline'),
                'online_exp'       => request('online_exp'),
                'home_exp'         => request('home_exp'),
                'profession'       => request('profession'),
                'min_salary'       => request('min_salary'),
                'max_salary'       => request('max_salary'),
                'ready_to_work'    => request('ready_to_work'),
            ]
        );

        return back()->with('success', 'Teaching details updated');
  }


    /* ================= EXTRA INFO ================= */
    public function updateExtraInfo(Request $request)
    {

        $user = auth()->user();

        $teacher = Teacher::where('user_id', $user->id)->first();

        $teacher->update([
            'qualifications'   => request('qualifications'),
            'session_fee'      => request('price_per_hour'),
            'bio'              => request('bio'),
            'speaking_languages'=> request('speaking_languages'),
            'year_exp'         => request('year_exp'),
        ]);

        return back()->with('success', 'Extra information updated');
    }
  /*
    |--------------------------------------------------------------------------
    | TEACHING GRADE UPDATE
    |--------------------------------------------------------------------------
    */
  public function editTeachingSlots(Request $request)
  {

    $user = auth()->user();

    $days = [
      'sun' => 'Sunday',
      'mon' => 'Monday',
      'tue' => 'Tuesday',
      'wed' => 'Wednesday',
      'thu' => 'Thursday',
      'fri' => 'Friday',
      'sat' => 'Saturday',
    ];


    // generate 5AM → 11PM slots
    $timeSlots = [];
    $start = strtotime("05:00");
    $end   = strtotime("23:00");

    while ($start < $end) {
      $timeSlots[] = [
        'start' => date('H:i:s', $start),
        'label' => date('h.i', $start) . '-' . date('h.i A', $start + 3600),
      ];
      $start += 3600;
    }

    // selected slots
    $selectedSlots = [];

    $existing = TeacherWorkingDay::with('slots')->where('teacher_id', $user->id)->get();
    $selectedSlots = [];

    foreach ($existing as $dayRow) {

      $dayName = $dayRow->day; // sun, mon, etc OR Sunday (depends on your column)

      foreach ($dayRow->slots as $slot) {

        // Convert DB time → label format (same as Blade)
        $start = $slot->time_slot;
        $label = $slot->time_slot;

        $selectedSlots[$dayName][] = $label;
      }
    }

    return view('teacher.settings.tabs.teaching-slots', compact('days', 'timeSlots', 'selectedSlots'));
  }

  public function updateTeachingSlots(Request $request)
  {
    $user = auth()->user();
    DB::beginTransaction();

    try {

      // 1️⃣ Delete old data
      TeacherWorkingDay::where('teacher_id', $user->id)->delete();

      // 2️⃣ Insert new data
      if ($request->slots) {
        foreach ($request->slots as $dayName => $timeSlots) {
          // Insert day
          $day = TeacherWorkingDay::create([
            'teacher_id' => $user->id,
            'day'   => $dayName,
          ]);

          foreach ($timeSlots as $slot) {

            TeacherWorkingHour::create([
              'teacher_id' => $user->id,
              'available_day_id' => $day->id,
              'time_slot' => $slot,
            ]);
          }
        }
      }

      DB::commit();

      return back()->with('success', 'Teaching slots updated successfully');
    } catch (\Exception $e) {

      DB::rollBack();
      return back()->with('error', $e->getMessage());
    }
  }

  public function editTeachingGrades(Request $request)
  {
    $teacher = auth()->user();

    $grades = Grade::with([
      'boards' => function ($q) {
        $q->where('published', 1)
          ->with(['subjects' => function ($q2) {
            $q2->where('published', 1);
          }]);
      }
    ])->where('published', 1)->get();

    // ✅ Full teaching details for edit
    $teacherDetails = TeachersTeachingGradeDetail::where('user_id', $teacher->id)->get();

    return view(
      'teacher.settings.tabs.teaching-grades',
      compact('grades', 'teacherDetails')
    );
  }

  public function updateTeachingGrades(Request $request)
  {
    DB::beginTransaction();
    try {
      $teacher = auth()->user();

      // delete old
      TeachersTeachingGradeDetail::where('user_id', $teacher->id)->delete();

      if ($request->has('data')) {
        foreach ($request->data as $gradeId => $boardIds) {
          foreach ($boardIds as $board_id => $boardId) {
            foreach ($boardId ?? [] as $subjects) {
              foreach ($subjects ?? [] as $subject) {
                if (isset($subject['id'])) {
                  TeachersTeachingGradeDetail::create([
                    'user_id'    => $teacher->id,
                    'grade_id'   => $gradeId,
                    'board_id'   => $board_id,
                    'subject_id' => $subject['id'],
                    'online'     => isset($subject['online']) ? 1 : 1,
                    'offline'    => isset($subject['offline']) ? 1 : 0,
                  ]);
                }
              }
            }
          }
        }
      }
      DB::commit();
      return back()->with('success', 'Teaching details updated');
    } catch (Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Teaching details updation filed' . $e->getMessage());
    }
  }


  public function accountDeleteRequest(Request $request)
  {
    $user = auth()->user();

    // Check existing pending request
    $existing = DeleteAccountRequest::where('user_id', $user->id)
      ->where('status', 'pending')
      ->first();

    if ($existing) {
      return response()->json([
        'status' => false,
        'message' => 'A delete account request is already pending.'
      ], 400);
    }

    $deleteReq = DeleteAccountRequest::create([
      'company_id' => $user->company_id,
      'user_id' => $user->id,
      'reason' => $request->reason,
      'description' => $request->description,
    ]);

    return redirect()->back()->with('success', 'Your account deletion requested successfully');
  }


  public function feedbackStore(Request $request)
  {

    return redirect()->back()->with('success', 'Your feedback saved successfully');
  }


  public function changePassword(Request $request)
  {
    $request->validate([
      'new_password' => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    // // check current password
    // if (!Hash::check($request->current_password, $user->password)) {
    //   return back()->withErrors([
    //     'current_password' => 'Current password is incorrect'
    //   ]);
    // }

    // update password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password changed successfully');
  }
}
