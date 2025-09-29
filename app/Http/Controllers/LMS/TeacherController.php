<?php

namespace App\Http\Controllers\LMS;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\TeacherGrade;
use App\Models\TeacherProfessionalInfo;
use App\Models\TeacherWorkingDay;
use App\Models\TeacherWorkingHour;
use App\Models\TeachingSubject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TeacherController extends Controller
{

  public function index()
  {
    $teachers = User::with('professionalInfo')
      ->where('company_id', 1)
      ->where('acc_type', 'teacher')
      ->get();

    // Group by status
    $verifiedTeachers    = $teachers->where('account_status', 'verified');
    $unverifiedTeachers  = $teachers->where('account_status', 'in progress');
    $rejectedTeachers    = $teachers->where('account_status', 'rejected');

    // Helper to count by teaching mode
    $countByMode = function ($collection, $mode) {
      return $collection->filter(fn($t) => $t->professionalInfo?->teaching_mode === $mode)->count();
    };

    $data = [
      'total' => [
        'teachers'        => $teachers->count(),
        'online_teachers' => $countByMode($teachers, 'online'),
        'offline_teachers' => $countByMode($teachers, 'offline'),
        'both_teachers'   => $countByMode($teachers, 'both'),
      ],
      'verified' => [
        'teachers'        => $verifiedTeachers->count(),
        'online_teachers' => $countByMode($verifiedTeachers, 'online'),
        'offline_teachers' => $countByMode($verifiedTeachers, 'offline'),
        'both_teachers'   => $countByMode($verifiedTeachers, 'both'),
      ],
      'unverified' => [
        'teachers'        => $unverifiedTeachers->count(),
        'online_teachers' => $countByMode($unverifiedTeachers, 'online'),
        'offline_teachers' => $countByMode($unverifiedTeachers, 'offline'),
        'both_teachers'   => $countByMode($unverifiedTeachers, 'both'),
      ],
      'rejected' => [
        'teachers'        => $rejectedTeachers->count(),
        'online_teachers' => $countByMode($rejectedTeachers, 'online'),
        'offline_teachers' => $countByMode($rejectedTeachers, 'offline'),
        'both_teachers'   => $countByMode($rejectedTeachers, 'both'),
      ],
    ];

    $teachers = User::where('acc_type', 'teacher')->where('company_id', 1)->paginate('10');

    return view('company.teachers.index', compact('data', 'teachers'));
  }

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
    $company_id = 1;

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
            'day'        => trim(strtolower($day)),
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
            'grade'      => trim(strtolower($grade)),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        TeachingSubject::where('teacher_id', $user->id)->delete();
        foreach ($allSubjects as $subject) {
          TeachingSubject::create([
            'teacher_id' => $user->id,
            'subject'    => trim(strtolower($subject)),
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

      // 8️⃣ Mark profile as filled
      $user->profile_fill = 1;
      $user->save();

      Log::info($user);

      DB::commit();

      return redirect()->route('admin.teachers')->with('success', 'Teacher created successfully!');
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
    $company_id = 1;

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
      }

       if ($currentStage === 'upload demo class' && $newStatus === 'completed') {
        $teacher->current_account_stage = 'account verified';
        $teacher->account_status = 'completed';
      }

      // if ($request->filled('acccount_notes')) {
        $teacher->notes = $request->acccount_notes;
      // }

      // RULE 4: Other statuses (pending/rejected/in progress) → only update account_status
      // No stage change

      $teacher->save();



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

      // 8️⃣ Mark profile as filled
      $teacher->profile_fill = 1;
      $teacher->save();

      Log::info($teacher);

      DB::commit();

      return redirect()->route('admin.teachers')->with('success', 'Teacher created successfully!');
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


  public function loginSecurity($id)
  {
    $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();
    return view('company.teachers.login-security', compact('teacher'));
  }


  public function loginSecurityChange($id, Request $request)
  {
    DB::beginTransaction();
    try {
      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if (!$teacher) {
        return redirect()->back(['error' => 'Teacher not found'], 404);
      }

      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if ($request->filled('password')) {
        $teacher->password = $request->password;
      }

      $teacher->email  = $request->email;
      $teacher->mobile = $request->mobile;
      $teacher->save();

      DB::commit();

      return redirect()->route('admin.teachers.index')->with('success', 'Teacher login security updated successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with(['error', 'Failed to teacher login security updation' . $e->getMessage()]);
    }
  }
}
