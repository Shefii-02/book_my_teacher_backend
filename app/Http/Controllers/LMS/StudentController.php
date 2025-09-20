<?php

namespace App\Http\Controllers\LMS;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\StudentAvailableDay;
use App\Models\StudentAvailableHour;
use App\Models\StudentGrade;
use App\Models\StudentPersonalInfo;
use App\Models\studentProfessionalInfo;
use App\Models\StudentRecommendedSubject;
use App\Models\studentWorkingDay;
use App\Models\studentWorkingHour;
use App\Models\TeachingSubject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{

  public function index()
  {
    $students = User::with('professionalInfo')
      ->where('company_id', 1)
      ->where('acc_type', 'student')
      ->get();

    // Group by status
    $verifiedstudents    = $students->where('account_status', 'verified');
    $unverifiedstudents  = $students->where('account_status', 'in progress');
    $rejectedstudents    = $students->where('account_status', 'rejected');

    $threeWeeksAgo = Carbon::now()->subWeeks(3);

    $unActive = User::where('last_activation', '<', $threeWeeksAgo)->get();

    // Helper to count by teaching mode
    $countByMode = function ($collection, $mode) {
      return $collection->filter(fn($t) => $t->studentPersonalInfo?->study_mode === $mode)->count();
    };

    $data = [
      'total' => [
        'students'        => $students->count(),
        'online_students' => $countByMode($students, 'online'),
        'offline_students' => $countByMode($students, 'offline'),
        'both_students'   => $countByMode($students, 'both'),
      ],
      'joined' => [
        'students'        => $verifiedstudents->count(),
        'online_students' => $countByMode($verifiedstudents, 'online'),
        'offline_students' => $countByMode($verifiedstudents, 'offline'),
        'both_students'   => $countByMode($verifiedstudents, 'both'),
      ],
      'unjoined' => [
        'students'        => $unverifiedstudents->count(),
        'online_students' => $countByMode($unverifiedstudents, 'online'),
        'offline_students' => $countByMode($unverifiedstudents, 'offline'),
        'both_students'   => $countByMode($unverifiedstudents, 'both'),
      ],
      'unactive' => [
        'students'        => $unActive->count(),
        'online_students' => $countByMode($unActive, 'online'),
        'offline_students' => $countByMode($unActive, 'offline'),
        'both_students'   => $countByMode($unActive, 'both'),
      ],
    ];

    $students = User::where('acc_type', 'student')->where('company_id', 1)->paginate('10');

    return view('company.students.index', compact('data', 'students'));
  }

  public function overview($id)
  {
    $student = User::with([
      'professionalInfo',
      'workingDays',
      'workingHours',
      'StudentGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'student')->first();

    if (!$student) {
      return response()->json(['message' => 'student not found'], 404);
    }

    return view('company.students.overview', compact('student'));
  }

  public function create()
  {

    return view('company.students.create');
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
          'acc_type'    => 'student',
          'city'        => $request->city,
          'postal_code' => $request->postal_code,
          'district'    => $request->district,
          'state'       => $request->state,
          'country'     => $request->country,
          'company_id'  => $company_id,
        ]
      );


      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = StudentPersonalInfo::updateOrCreate(
        ['student_id' => $user->id],
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
        StudentAvailableDay::where('student_id', $user->id)->delete();
        foreach ($request->working_days as $day) {
          StudentAvailableDay::create([
            'student_id' => $user->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('working_hours')) {
        StudentAvailableHour::where('student_id', $user->id)->delete();
        foreach ($request->working_hours as $hour) {
          StudentAvailableHour::create([
            'student_id' => $user->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('teaching_grades')) {
        StudentGrade::where('student_id', $user->id)->delete();
        foreach ($request->teaching_grades as $grade) {
          StudentGrade::create([
            'student_id' => $user->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        TeachingSubject::where('student_id', $user->id)->delete();
        foreach ($allSubjects as $subject) {
          TeachingSubject::create([
            'student_id' => $user->id,
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

      // 8️⃣ Mark profile as filled
      $user->profile_fill = 1;
      $user->save();

      Log::info($user);

      DB::commit();

      return redirect()->back()->with('success', 'student created successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'student creation failed! ' . $e->getMessage());
    }
  }
  public function edit($id)
  {


    $user = User::with([
      'professionalInfo',
      'workingDays',
      'workingHours',
      'StudentGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'student')->first();

    if (!$user) {
      return response()->json(['message' => 'student not found'], 404);
    }

    return view('company.students.edit', compact('user'));
  }

  public function update(Request $request, $id)
  {

    $student = User::where('id', $id)->where('acc_type', 'student')->first();

    if (!$student) {
      return response()->json(['message' => 'student not found'], 404);
    }



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

      $student->update([
        'name'        => $request->name ?? $student->name,
        'email'       => $request->email ?? $student->email,
        'mobile'      => $request->phone ?? $student->mobile,
        'address'     => $request->address ?? $student->address,
        'city'        => $request->city ?? $student->city,
        'postal_code' => $request->postal_code ?? $student->postal_code,
        'district'    => $request->district ?? $student->district,
        'state'       => $request->state ?? $student->state,
        'country'     => $request->country ?? $student->country,
        'account_status' =>  $request->account_status ?? $student->account_status,
      ]);


      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = studentPersonalInfo::updateOrCreate(
        ['student_id' => $student->id],
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
        StudentAvailableDay::where('student_id', $student->id)->delete();
        foreach ($request->working_days as $day) {
          StudentAvailableDay::create([
            'student_id' => $student->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('working_hours')) {

        StudentAvailableHour::where('student_id', $student->id)->delete();
        foreach ($request->working_hours as $hour) {
          StudentAvailableHour::create([
            'student_id' => $student->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('teaching_grades')) {
        StudentGrade::where('student_id', $student->id)->delete();
        foreach ($request->teaching_grades as $grade) {
          StudentGrade::create([
            'student_id' => $student->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        TeachingSubject::where('student_id', $student->id)->delete();
        foreach ($allSubjects as $subject) {
          TeachingSubject::create([
            'student_id' => $student->id,
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
          'user_id' => $student->id,
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
          'user_id' => $student->id,
          'company_id' => $company_id,
          'file_type'  => 'cv', // ✅ FIXED
          'file_path'  => $cvPath, // ✅ FIXED
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);
      }

      // 8️⃣ Mark profile as filled
      $student->profile_fill = 1;
      $student->save();

      Log::info($student);

      DB::commit();

      return redirect()->back()->with('success', 'student created successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'student creation failed! ' . $e->getMessage());
    }
  }


  /**
   * student Delete
   */
  public function delete($id)
  {
    DB::beginTransaction();
    try {
      $student = User::where('id', $id)->where('acc_type', 'student')->first();

      if (!$student) {
        return redirect()->back()->with('error', 'student not found');
      }

      // Delete related data
      StudentPersonalInfo::where('student_id', $student->id)->delete();
      StudentAvailableDay::where('student_id', $student->id)->delete();
      StudentAvailableHour::where('student_id', $student->id)->delete();
      StudentGrade::where('student_id', $student->id)->delete();
      StudentRecommendedSubject::where('student_id', $student->id)->delete();
      MediaFile::where('user_id', $student->id)->delete();

      // Delete student account
      $student->delete();
      DB::commit();
      return redirect()->back()->with('success', 'student deleted successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Failed to delete student' . $e->getMessage());
    }
  }


  public function loginSecurity($id)
  {
    $student = User::where('id', $id)->where('acc_type', 'student')->first();
    return view('company.students.login-security', compact('student'));
  }


  public function loginSecurityChange($id, Request $request)
  {
    DB::beginTransaction();
    try {
      $student = User::where('id', $id)->where('acc_type', 'student')->first();

      if (!$student) {
        return redirect()->back(['error' => 'student not found'], 404);
      }

      $student = User::where('id', $id)->where('acc_type', 'student')->first();

      if ($request->filled('password')) {
        $student->password = $request->password;
      }

      $student->email  = $request->email;
      $student->mobile = $request->mobile;
      $student->save();

      DB::commit();

      return redirect()->route('admin.students.index')->with('success', 'student deleted successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with(['error', 'Failed to delete student' . $e->getMessage()]);
    }
  }
}
