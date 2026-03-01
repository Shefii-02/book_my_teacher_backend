<?php

namespace App\Http\Controllers\LMS;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\MediaFile;
use App\Models\Teacher;
use App\Models\TeacherGrade;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeachersTeachingGradeDetail;
use App\Models\TeacherWorkingDay;
use App\Models\TeacherWorkingHour;
use App\Models\TeachingSubject;
use App\Models\User;
use App\Models\UserAdditionalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{
  public function index(Request $request)
  {
    // ----- Summary Data -----
    $allTeachers = User::with('professionalInfo')
      ->where('company_id', 1)
      ->where('acc_type', 'teacher')
      ->get();

    $countByMode = fn($collection, $mode) =>
    $collection->filter(fn($t) => $t->professionalInfo?->teaching_mode === $mode)->count();

    $data = [
      'total' => [
        'teachers'        => $allTeachers->count(),
        'online_teachers' => $countByMode($allTeachers, 'online'),
        'offline_teachers' => $countByMode($allTeachers, 'offline'),
        'both_teachers'   => $countByMode($allTeachers, 'both'),
      ],
      'unverified' => [
        'teachers'        => $allTeachers->where('current_account_stage', '!=', 'account verified')->where('account_status', '!=', 'rejected')->count(),
        'online_teachers' => $countByMode($allTeachers->where('current_account_stage', '!=', 'account verified')->where('account_status', '!=', 'rejected'), 'online'),
        'offline_teachers' => $countByMode($allTeachers->where('current_account_stage', '!=', 'account verified')->where('account_status', '!=', 'rejected'), 'offline'),
        'both_teachers'   => $countByMode($allTeachers->where('current_account_stage', '!=', 'account verified')->where('account_status', '!=', 'rejected'), 'both'),
      ],
      'verified' => [
        'teachers'        => $allTeachers->where('current_account_stage', 'account verified')->count(),
        'online_teachers' => $countByMode($allTeachers->where('current_account_stage', 'account verified'), 'online'),
        'offline_teachers' => $countByMode($allTeachers->where('current_account_stage', 'account verified'), 'offline'),
        'both_teachers'   => $countByMode($allTeachers->where('current_account_stage', 'account verified'), 'both'),
      ],
      'rejected' => [
        'teachers'        => $allTeachers->where('account_status', 'rejected')->count(),
        'online_teachers' => $countByMode($allTeachers->where('account_status', 'rejected'), 'online'),
        'offline_teachers' => $countByMode($allTeachers->where('account_status', 'rejected'), 'offline'),
        'both_teachers'   => $countByMode($allTeachers->where('account_status', 'rejected'), 'both'),
      ],
    ];

    // ----- Listing Query -----
    // $query = User::with('professionalInfo')
    //   ->where('company_id', 1)
    //   ->where('acc_type', 'teacher');
    // ----- Listing Query -----
    $company_id = auth()->user()->company_id;
    $query = User::with('professionalInfo')
      ->where('company_id', $company_id)
      ->where('acc_type', 'teacher');

    // 🧭 Tabs logic
    $tab = $request->get('tab', 'pending');

    if ($tab === 'approved') {
      $query->where('current_account_stage', 'account verified')
        ->where('account_status', '!=', 'rejected');
    }

    if ($tab === 'rejected') {
      $query->where('account_status', 'rejected');
    }

    if ($tab === 'pending') {

      $query->where('current_account_stage', '!=', 'account verified')
        ->where('account_status', '!=', 'rejected');
    }


    // 🔍 Global search
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('mobile', 'like', "%$search%");
      });
    }

    // 🎛 Dropdown filters
    if ($request->filled('teaching_mode')) {
      $query->whereHas('professionalInfo', function ($q) use ($request) {
        $q->where('teaching_mode', $request->teaching_mode);
      });
    }

    // if ($request->filled('account_status')) {
    //   $query->where('account_status', $request->account_status);
    // }

    // if ($request->filled('current_account_stage')) {
    //   $query->where('current_account_stage', $request->current_account_stage);
    // }

    $teachers = $query->paginate(50)->appends($request->query());

    return view('company.teachers.index', compact('teachers', 'data'));
  }

  // public function exportTeachers(Request $request)
  // {
  //   // ----- Build Same Query As Listing -----
  //   $query = User::with('professionalInfo')
  //     ->where('company_id', 1)
  //     ->where('acc_type', 'teacher');

  //   if ($request->filled('search')) {
  //     $search = $request->search;
  //     $query->where(function ($q) use ($search) {
  //       $q->where('name', 'like', "%$search%")
  //         ->orWhere('email', 'like', "%$search%")
  //         ->orWhere('mobile', 'like', "%$search%");
  //     });
  //   }

  //   if ($request->filled('teaching_mode')) {
  //     $query->whereHas('professionalInfo', function ($q) use ($request) {
  //       $q->where('teaching_mode', $request->teaching_mode);
  //     });
  //   }

  //   if ($request->filled('account_status')) {
  //     $query->where('account_status', $request->account_status);
  //   }

  //   if ($request->filled('current_account_stage')) {
  //     $query->where('current_account_stage', $request->current_account_stage);
  //   }

  //   $teachers = $query->get();


  //   // ----- Excel Export (tab-delimited) -----
  //   $fileName = "teachers_export_" . now()->format('Ymd_His') . ".xls";

  //   header("Content-Type: application/vnd.ms-excel");
  //   header("Content-Disposition: attachment; filename=\"$fileName\"");
  //   header("Pragma: no-cache");
  //   header("Expires: 0");

  //   // Output headers
  //   echo "ID\tName\tEmail\tMobile\tAddress\tCity\tDistrict\tState\tCountry\tTeaching Mode\tAccount Status\tAccount Stage\tCreated At\n";

  //   foreach ($teachers as $t) {
  //     echo $t->id . "\t" .
  //       $t->name . "\t" .
  //       $t->email . "\t" .
  //       $t->mobile . "\t" .
  //       $t->address . "\t" .
  //       $t->city . "\t" .
  //       $t->postal_code . "\t" .
  //       $t->district . "\t" .
  //       $t->state . "\t" .
  //       $t->country . "\t" .
  //       ($t->professionalInfo->teaching_mode ?? '-') . "\t" .
  //       $t->account_status . "\t" .
  //       $t->current_account_stage . "\t" .
  //       $t->created_at . "\n";
  //   }

  //   exit;
  // }

  public function exportTeachers(Request $request)
  {
    $company_id = auth()->user()->company_id;
    // ----- Build Same Query As Listing -----
    $query = User::with(['professionalInfo', 'subjects'])
      ->where('company_id', $company_id)
      ->where('acc_type', 'teacher');

    $tab = $request->get('tab', 'pending');

    if ($tab === 'approved') {
      $query->where('current_account_stage', 'account verified')
        ->where('account_status', '!=', 'rejected');
    }

    if ($tab === 'rejected') {
      $query->where('account_status', 'rejected');
    }

    if ($tab === 'pending') {

      $query->where('current_account_stage', '!=', 'account verified')
        ->where('account_status', '!=', 'rejected');
    }

    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('mobile', 'like', "%$search%");
      });
    }



    if ($request->filled('teaching_mode')) {
      $query->whereHas('professionalInfo', function ($q) use ($request) {
        $q->where('teaching_mode', $request->teaching_mode);
      });
    }

    if ($request->filled('account_status')) {
      $query->where('account_status', $request->account_status);
    }

    if ($request->filled('current_account_stage')) {
      $query->where('current_account_stage', $request->current_account_stage);
    }

    $teachers = $query->get();

    // ----- Excel Export (tab-delimited) -----
    $fileName = "teachers_export_" . now()->format('Ymd_His') . ".xls";

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Output headers
    echo "ID\tName\tEmail\tMobile\tAddress\tCity\tDistrict\tState\tCountry\tSubjects\tTeaching Mode\tAccount Status\tAccount Stage\tCreated At\n";

    foreach ($teachers as $t) {
      // Get subjects list (comma separated)
      $subjects = $t->subjects
        ? $t->subjects->pluck('subject')->implode(', ')
        : '-';

      echo $t->id . "\t" .
        $t->name . "\t" .
        $t->email . "\t" .
        $t->mobile . "\t" .
        ($t->address ?? '-') . "\t" .
        ($t->city ?? '-') . "\t" .
        ($t->district ?? '-') . "\t" .
        ($t->state ?? '-') . "\t" .
        ($t->country ?? '-') . "\t" .
        $subjects . "\t" .
        ($t->professionalInfo->teaching_mode ?? '-') . "\t" .
        ($t->account_status ?? '-') . "\t" .
        ($t->current_account_stage ?? '-') . "\t" .
        $t->created_at . "\n";
    }

    exit;
  }





  // public function index()
  // {
  //   $teachers = User::with('professionalInfo')
  //     ->where('company_id', 1)
  //     ->where('acc_type', 'teacher')
  //     ->get();

  //   // Group by status
  //   $verifiedTeachers    = $teachers->where('account_status', 'verified');
  //   $unverifiedTeachers  = $teachers->where('account_status', 'in progress');
  //   $rejectedTeachers    = $teachers->where('account_status', 'rejected');

  //   // Helper to count by teaching mode
  //   $countByMode = function ($collection, $mode) {
  //     return $collection->filter(fn($t) => $t->professionalInfo?->teaching_mode === $mode)->count();
  //   };

  //   $data = [
  //     'total' => [
  //       'teachers'        => $teachers->count(),
  //       'online_teachers' => $countByMode($teachers, 'online'),
  //       'offline_teachers' => $countByMode($teachers, 'offline'),
  //       'both_teachers'   => $countByMode($teachers, 'both'),
  //     ],
  //     'verified' => [
  //       'teachers'        => $verifiedTeachers->count(),
  //       'online_teachers' => $countByMode($verifiedTeachers, 'online'),
  //       'offline_teachers' => $countByMode($verifiedTeachers, 'offline'),
  //       'both_teachers'   => $countByMode($verifiedTeachers, 'both'),
  //     ],
  //     'unverified' => [
  //       'teachers'        => $unverifiedTeachers->count(),
  //       'online_teachers' => $countByMode($unverifiedTeachers, 'online'),
  //       'offline_teachers' => $countByMode($unverifiedTeachers, 'offline'),
  //       'both_teachers'   => $countByMode($unverifiedTeachers, 'both'),
  //     ],
  //     'rejected' => [
  //       'teachers'        => $rejectedTeachers->count(),
  //       'online_teachers' => $countByMode($rejectedTeachers, 'online'),
  //       'offline_teachers' => $countByMode($rejectedTeachers, 'offline'),
  //       'both_teachers'   => $countByMode($rejectedTeachers, 'both'),
  //     ],
  //   ];

  //   $teachers = User::where('acc_type', 'teacher')->where('company_id', 1)->paginate('10');

  //   return view('company.teachers.index', compact('data', 'teachers'));
  // }

  public function overview($id)
  {
    $teacher = User::with([
      'professionalInfo',
      'workingDays',
      'workingHours',
      'teacherGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'teacher')->first();

    if (!$teacher) {
      return redirect()->back()->with('error', 'Teacher not found');
    }

    return view('company.teachers.overview', compact('teacher'));
  }

  public function create()
  {

    return view('company.teachers.create');
  }

  public function store(Request $request)
  {
    DB::beginTransaction();
    $company_id = auth()->user()->company_id;

    $teachingSubjects = $request->input('teaching_subjects', []); // array
    $otherSubject = $request->input('other_subject'); // string

    // Merge into one array
    $allSubjects = $teachingSubjects;

    if ($request->filled('other_subject')) {
      if (!empty($otherSubject)) {
        $allSubjects[] = $otherSubject; // Add only if not null
      }

      $allSubjects = array_filter(array_merge(
        $request->input('teaching_subjects', []),
        [$request->input('other_subject')]
      ));
    }

    Log::info($request->all());
    try {
      // 1️⃣ Create or Update User
      $user = User::create(
        [
          'name'        => $request->name,
          'email'       => $request->email,
          'mobile'      => $request->phone,
          'address'     => $request->address,
          'acc_type'    => 'teacher',
          'city'        => $request->city,
          'postal_code' => $request->postal_code,
          'district'    => $request->district,
          'state'       => $request->state,
          'country'     => $request->country,
          'company_id'  => $company_id,
        ]
      );


      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = TeacherProfessionalInfo::updateOrCreate(
        ['teacher_id' => $user->id],
        [
          'profession'    => $request->profession,
          'ready_to_work' => $request->ready_to_work,
          'teaching_mode' => $request->mode,
          'offline_exp'   => $request->offline_exp,
          'online_exp'    => $request->online_exp,
          'home_exp'      => $request->home_exp,
        ]
      );


      // 3️⃣ Sync Working Days
      if ($request->filled('working_days')) {
        TeacherWorkingDay::where('teacher_id', $user->id)->delete();
        foreach ($request->working_days as $day) {
          TeacherWorkingDay::create([
            'teacher_id' => $user->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('working_hours')) {
        TeacherWorkingHour::where('teacher_id', $user->id)->delete();
        foreach ($request->working_hours as $hour) {
          TeacherWorkingHour::create([
            'teacher_id' => $user->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('teaching_grades')) {
        TeacherGrade::where('teacher_id', $user->id)->delete();
        foreach ($request->teaching_grades as $grade) {
          TeacherGrade::create([
            'teacher_id' => $user->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        TeachingSubject::where('teacher_id', $user->id)->delete();
        foreach ($allSubjects as $subject) {
          TeachingSubject::create([
            'teacher_id' => $user->id,
            'subject'    => trim($subject),
          ]);
        }
      }

      // 7️⃣ Media Files (Avatar + CV)
      if ($request->hasFile('avatar')) {
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

      if ($request->hasFile('cv_file')) {
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

      UserAdditionalInfo::where('company_id', 1)->where('user_id', $user->id)->delete();
      if ($request->has('additional')) {
        foreach ($request->additional as $field) {
          if (!empty($field['key_title'])) {
            UserAdditionalInfo::create([
              'user_id' => $user->id,
              'key_title' => $field['key_title'],
              'key_value' => $field['key_value'] ?? '',
              'company_id' => 1,
            ]);
          }
        }
      }

      // 8️⃣ Mark profile as filled
      $user->profile_fill = 1;
      $user->save();

      Log::info($user);

      DB::commit();

      return redirect()->route('company.teachers.index')->with('success', 'Teacher created successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Teacher creation failed! ' . $e->getMessage());
    }
  }
  public function edit($id)
  {
    $user = User::with([
      'professionalInfo',
      'workingDays',
      'workingHours',
      'teacherGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'teacher')->first();

    if (!$user) {
      return redirect()->back()->with('error', 'Teacher not found');
    }

    return view('company.teachers.edit', compact('user'));
  }

  public function update(Request $request, $id)
  {


    $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

    if (!$teacher) {
      return redirect()->back()->with('error', 'Teacher not found');
    }

    $request->validate([
      'account_status' => 'required|in:scheduled,completed,in progress,pending,rejected',
      'interview_at' => 'nullable|date',
      'acccount_notes' => 'nullable|string|max:1000',
    ]);

    DB::beginTransaction();
    $company_id = auth()->user()->company_id;

    $teachingSubjects = $request->input('teaching_subjects', []); // array
    $otherSubject = $request->input('other_subject'); // string

    // Merge into one array
    $allSubjects = $teachingSubjects;

    if ($request->filled('other_subject')) {
      if (!empty($otherSubject)) {
        $allSubjects[] = $otherSubject; // Add only if not null
      }

      $allSubjects = array_filter(array_merge(
        $request->input('teaching_subjects', []),
        [$request->input('other_subject')]
      ));
    }



    Log::info($request->all());


    try {
      // 1️⃣  Update User

      $teacher->update([
        'name'        => $request->name ?? $teacher->name,
        'email'       => $request->email ?? $teacher->email,
        'mobile'      => $request->phone ?? $teacher->mobile,
        'address'     => $request->address ?? $teacher->address,
        'city'        => $request->city ?? $teacher->city,
        'postal_code' => $request->postal_code ?? $teacher->postal_code,
        'district'    => $request->district ?? $teacher->district,
        'state'       => $request->state ?? $teacher->state,
        'country'     => $request->country ?? $teacher->country,
        // 'account_status' =>  $request->account_status ?? $teacher->account_status,
      ]);



      $currentStage = $teacher->current_account_stage;
      $newStatus = $request->account_status;

      $teacher->account_status = $newStatus;

      // === RULE 1: Verification Process Completed ===
      if ($currentStage === 'verification process' && $newStatus === 'completed') {
        $teacher->current_account_stage = 'schedule interview';
        $teacher->account_status = 'in progress';
      }

      // === RULE 2: Schedule Interview Completed ===
      elseif ($currentStage === 'schedule interview' && $newStatus === 'completed') {
        $teacher->current_account_stage = 'upload demo class';
        $teacher->account_status = 'in progress';
      }

      // === RULE 3: Schedule Interview Scheduled ===
      elseif ($currentStage === 'schedule interview' && $newStatus === 'scheduled') {
        // Stay in same stage
        $teacher->account_status = 'scheduled';

        if ($request->filled('interview_at')) {
          $teacher->interview_at = $request->interview_at;
        }
      } elseif ($currentStage === 'upload demo class' && $newStatus === 'completed') {
        $teacher->current_account_stage = 'account verified';
        $teacher->account_status = 'completed';
      }


      // if ($request->filled('acccount_notes')) {
      $teacher->notes = $request->acccount_notes;
      // }

      // RULE 4: Other statuses (pending/rejected/in progress) → only update account_status
      // No stage change

      $teacher->save();


      if ($newStatus = 'verified') {
        $teacherProfile = Teacher::where('user_id', $teacher->id)->where('company_id', auth()->user()->company_id)->first();
        if (!$teacherProfile) {
          $teacherProfile           = new Teacher();
          $teacherProfile->user_id  = $teacher->id;
          $teacherProfile->name     = $teacher->name;
          $teacherProfile->company_id = auth()->user()->company_id;
          $teacherProfile->published = 0;
          $teacherProfile->save();
        }
      }


      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = TeacherProfessionalInfo::updateOrCreate(
        ['teacher_id' => $teacher->id],
        [
          'profession'    => $request->profession,
          'ready_to_work' => $request->ready_to_work,
          'teaching_mode' => $request->mode,
          'offline_exp'   => $request->offline_exp,
          'online_exp'    => $request->online_exp,
          'home_exp'      => $request->home_exp,
        ]
      );


      // 3️⃣ Sync Working Days
      if ($request->filled('working_days')) {
        TeacherWorkingDay::where('teacher_id', $teacher->id)->delete();
        foreach ($request->working_days as $day) {
          TeacherWorkingDay::create([
            'teacher_id' => $teacher->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('working_hours')) {
        TeacherWorkingHour::where('teacher_id', $teacher->id)->delete();
        foreach ($request->working_hours as $hour) {
          TeacherWorkingHour::create([
            'teacher_id' => $teacher->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('teaching_grades')) {
        TeacherGrade::where('teacher_id', $teacher->id)->delete();
        foreach ($request->teaching_grades as $grade) {
          TeacherGrade::create([
            'teacher_id' => $teacher->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        TeachingSubject::where('teacher_id', $teacher->id)->delete();
        foreach ($allSubjects as $subject) {
          TeachingSubject::create([
            'teacher_id' => $teacher->id,
            'subject'    => trim($subject),
          ]);
        }
      }




      // 7️⃣ Media Files (Avatar + CV)
      if ($request->hasFile('avatar')) {
        MediaFile::where('company_id', $company_id)->where('user_id', $teacher->id)->where('file_type', 'avatar')->delete();
        $file = $request->file('avatar');
        $path = $file->storeAs(
          'uploads/avatars',
          time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
          'public'
        );

        MediaFile::create([
          'user_id' => $teacher->id,
          'company_id' => $company_id,
          'file_type'  => 'avatar',
          'file_path'  => $path,
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);
      }


      if ($request->hasFile('cv_file')) {
        MediaFile::where('company_id', $company_id)->where('user_id', $teacher->id)->where('file_type', 'cv')->delete();
        $file = $request->file('cv_file');
        $cvPath = $file->storeAs(
          'uploads/cv_files',
          time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
          'public'
        );

        MediaFile::create([
          'user_id' => $teacher->id,
          'company_id' => $company_id,
          'file_type'  => 'cv', // ✅ FIXED
          'file_path'  => $cvPath, // ✅ FIXED
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);
      }

      UserAdditionalInfo::where('company_id', 1)->where('user_id', $teacher->id)->delete();
      if ($request->has('additional')) {
        foreach ($request->additional as $field) {
          if (!empty($field['key_title'])) {
            UserAdditionalInfo::create([
              'user_id' => $teacher->id,
              'key_title' => $field['key_title'],
              'key_value' => $field['key_value'] ?? '',
              'company_id' => 1,
            ]);
          }
        }
      }

      // 8️⃣ Mark profile as filled
      $teacher->profile_fill = 1;
      $teacher->save();

      Log::info($teacher);

      DB::commit();

      return redirect()->route('company.teachers.index')->with('success', 'Teacher created successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Teacher creation failed! ' . $e->getMessage());
    }
  }


  /**
   * Teacher Delete
   */
  public function delete($id)
  {
    DB::beginTransaction();
    try {
      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if (!$teacher) {
        return redirect()->back()->with('success', 'Teacher not found');
      }

      // Delete related data
      TeacherProfessionalInfo::where('teacher_id', $teacher->id)->delete();
      TeacherWorkingDay::where('teacher_id', $teacher->id)->delete();
      TeacherWorkingHour::where('teacher_id', $teacher->id)->delete();
      TeacherGrade::where('teacher_id', $teacher->id)->delete();
      TeachingSubject::where('teacher_id', $teacher->id)->delete();
      MediaFile::where('user_id', $teacher->id)->delete();

      // Delete teacher account
      $teacher->delete();

      DB::commit();
      return redirect()->back()->with('success', 'Teacher deleted successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete teacher' . $e->getMessage());
    }
  }



  public function teachersSearch(Request $request)
  {


    $grades = Grade::with([
      'boards' => function ($q) {
        $q->where('published', 1);
      },
      'boards.subjects' => function ($q) {
        $q->where('published', 1);
      }
    ])->where('company_id', auth()->user()->company_id)
      ->where('published', 1)
      ->orderBy('position')
      ->get();

    $teachers = User::query();

    // ================= BASIC FILTERS =================

      if ($request->filled('status')) {
        if ($request->status == 'approved') {
          $teachers->where('status', 1);
        } else if ($request->status == 'pending') {
          $teachers->where('current_account_stage', '!=', 'account verified')->where('account_status', '!=', 'rejected');
        } else if ($request->status == 'rejected') {
          $teachers->where('account_status', '!=', 'rejected');
        }
      }
      if ($request->filled('district')) {
        $teachers->where('district', $request->district);
      }

      if ($request->filled('rating')) {
        $teachers->where('rating', '>=', $request->rating);
      }



    // ================= GRADE / BOARD / SUBJECT FILTER =================
    if (
      $request->filled('grade_id') ||
      $request->filled('board_id') ||
      $request->filled('subject_id') ||
      $request->filled('mode')
    ) {
      $teachers->whereHas('teachingDetails', function ($q) use ($request) {

        // Grade
        if ($request->filled('grade_id')) {
          $q->where('grade_id', $request->grade_id);
        }

        // Board
        if ($request->filled('board_id')) {
          $q->where('board_id', $request->board_id);
        }

        // MULTI SUBJECT
        if ($request->filled('subject_id')) {
          $q->whereIn('subject_id', $request->subject_id);
        }

        // MODE (online/offline)
        if ($request->filled('mode')) {
          if ($request->mode == 'online') {
            $q->where('online', 1);
          }

          if ($request->mode == 'offline') {
            $q->where('offline', 1);
          }
        }
      });
    }

    $teachers = $teachers
      ->latest()
      ->paginate(12)
      ->withQueryString();

    return view('company.teachers.search', compact('teachers', 'grades'));
  }
}
