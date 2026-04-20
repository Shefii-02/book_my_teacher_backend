<?php

namespace App\Http\Controllers\LMS;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Grade;
use App\Models\MediaFile;
use App\Models\StudentAvailableDay;
use App\Models\StudentAvailableHour;
use App\Models\StudentGrade;
use App\Models\StudentPersonalInfo;
use App\Models\StudentRecommendedSubject;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
  public function index(Request $request)
  {
    $company_id = auth()->user()->company_id;

    $query = User::with([
      'studentPersonalInfo',
      'recommendedSubjects',
      'studentGrades'
    ])
      ->where('company_id', $company_id)
      ->where('acc_type', 'student');

    /*
    |----------------------------------
    | Search
    |----------------------------------
    */
    if ($request->search) {
      $query->where(function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('email', 'like', "%{$request->search}%")
          ->orWhere('mobile', 'like', "%{$request->search}%");
      });
    }

    /*
    |----------------------------------
    | Teaching Mode
    |----------------------------------
    */
    if ($request->class_mode) {                              // ✅ was: $request->class_mode (correct key)
      $query->whereHas('studentPersonalInfo', function ($q) use ($request) {
        $q->where('study_mode', $request->class_mode);   // ✅ was: $request->teaching_mode (wrong key)
      });
    }

    /*
    |----------------------------------
    | Grade
    |----------------------------------
    */
    if ($request->learn_grade) {
      $query->whereHas('studentGrades', function ($q) use ($request) {
        $q->where('grade', $request->learn_grade);       // ✅ was: $request->teaching_grade (wrong key)
      });
    }

    /*
    |----------------------------------
    | Subject
    |----------------------------------
    */
    if ($request->learn_subject) {
      $query->whereHas('recommendedSubjects', function ($q) use ($request) {
        $q->where('subject', $request->learn_subject);   // ✅ was: $request->teaching_subject (wrong key)
      });
    }

    /*
    |----------------------------------
    | Admission Status
    |----------------------------------
    */
    if ($request->admisison_status == 'on-going') {
      $query->where('account_status', 'verified');
    }

    if ($request->admisison_status == 'un-purchased') {
      $query->where('account_status', 'in progress');
    }


    /*
    |----------------------------------
    | Course Filter (NEW)
    |----------------------------------
    */
    if ($request->course_filter == 'joined') {
      $query->whereHas('courseEnrolled');
    }

    if ($request->course_filter == 'unjoined') {
      $query->whereDoesntHave('courseEnrolled');
    }

    // Joined date
    if ($request->join_from && $request->join_to) {
      $query->whereBetween('created_at', [
        $request->join_from,
        $request->join_to
      ]);
    }

    // Last active date
    if ($request->active_from && $request->active_to) {
      $query->whereBetween('last_activation', [
        $request->active_from,
        $request->active_to
      ]);
    }

    /*
    |----------------------------------
    | Pagination
    |----------------------------------
    */
    $students = $query->latest()->paginate(10)->withQueryString();

    /*
    |----------------------------------
    | Dashboard Stats
    |----------------------------------
    | ✅ Fix: fetch ONE collection and split it in PHP
    |    instead of reusing a mutating query builder
    |----------------------------------
    */
    $threeWeeksAgo = Carbon::now()->subWeeks(3);

    $allStudents = User::with('studentPersonalInfo')
      ->where('company_id', $company_id)
      ->where('acc_type', 'student')
      ->get();                                             // ✅ single DB call, returns a Collection

    $courseJoinedStudents   = $allStudents->filter(fn($s) => $s->courseEnrolled?->isNotEmpty());
    $courseUnjoinedStudents = $allStudents->filter(fn($s) => !$s->courseEnrolled || $s->courseEnrolled->isEmpty());
    $unActiveStudents       = $allStudents->filter(fn($s) => $s->last_activation < $threeWeeksAgo);

    // ✅ Now $countByMode always receives a Collection
    $countByMode = fn($collection, $mode) => $collection
      ->filter(fn($s) => $s->studentPersonalInfo?->study_mode === $mode)
      ->count();

    $data = [
      'total' => [
        'students'         => $allStudents->count(),
        'online_students'  => $countByMode($allStudents, 'online'),
        'offline_students' => $countByMode($allStudents, 'offline'),
        'both_students'    => $countByMode($allStudents, 'both'),
      ],
      'joined' => [
        'students'         => $courseJoinedStudents->count(),
        'online_students'  => $countByMode($courseJoinedStudents, 'online'),
        'offline_students' => $countByMode($courseJoinedStudents, 'offline'),
        'both_students'    => $countByMode($courseJoinedStudents, 'both'),
      ],
      'unjoined' => [
        'students'         => $courseUnjoinedStudents->count(),
        'online_students'  => $countByMode($courseUnjoinedStudents, 'online'),
        'offline_students' => $countByMode($courseUnjoinedStudents, 'offline'),
        'both_students'    => $countByMode($courseUnjoinedStudents, 'both'),
      ],
      'unactive' => [
        'students'         => $unActiveStudents->count(),
        'online_students'  => $countByMode($unActiveStudents, 'online'),
        'offline_students' => $countByMode($unActiveStudents, 'offline'),
        'both_students'    => $countByMode($unActiveStudents, 'both'),
      ],
    ];

    $grades = Grade::where('company_id', $company_id)
      ->where('published', 1)
      ->orderBy('position')
      ->get();

    $boards = Board::where('company_id', $company_id)
      ->where('published', 1)
      ->orderBy('position')
      ->get();

    $subjects = Subject::where('company_id', $company_id)
      ->where('published', 1)
      ->orderBy('position')
      ->get();

    /*
    |----------------------------------
    | AJAX Response
    |----------------------------------
    */
    if ($request->ajax()) {
      return view('company.students.table', compact('students'))->render();
    }


    return view('company.students.index', compact('students', 'data', 'grades', 'boards', 'subjects'));
  }

  //   public function index(Request $request)
  // {
  //   $company_id = auth()->user()->company_id;

  //   $query = User::with([
  //     'studentPersonalInfo',
  //     'recommendedSubjects',
  //     'studentGrades',
  //     'courseEnrolled'
  //   ])
  //     ->where('company_id', $company_id)
  //     ->where('acc_type', 'student');

  //   /*
  //   |----------------------------------
  //   | Search
  //   |----------------------------------
  //   */
  //   if ($request->search) {
  //     $query->where(function ($q) use ($request) {
  //       $q->where('name', 'like', "%{$request->search}%")
  //         ->orWhere('email', 'like', "%{$request->search}%")
  //         ->orWhere('mobile', 'like', "%{$request->search}%");
  //     });
  //   }

  //   /*
  //   |----------------------------------
  //   | Study Mode
  //   |----------------------------------
  //   */
  //   if ($request->class_mode) {
  //     $query->whereHas('studentPersonalInfo', function ($q) use ($request) {
  //       $q->where('study_mode', $request->class_mode);
  //     });
  //   }

  //   /*
  //   |----------------------------------
  //   | Grade
  //   |----------------------------------
  //   */
  //   if ($request->learn_grade) {
  //     $query->whereHas('studentGrades', function ($q) use ($request) {
  //       $q->where('grade', $request->learn_grade);
  //     });
  //   }

  //   /*
  //   |----------------------------------
  //   | Subject
  //   |----------------------------------
  //   */
  //   if ($request->learn_subject) {
  //     $query->whereHas('recommendedSubjects', function ($q) use ($request) {
  //       $q->where('subject', $request->learn_subject);
  //     });
  //   }

  //   /*
  //   |----------------------------------
  //   | Course Filter (NEW)
  //   |----------------------------------
  //   */
  //   if ($request->course_filter == 'joined') {
  //     $query->whereHas('courseEnrolled');
  //   }

  //   if ($request->course_filter == 'unjoined') {
  //     $query->whereDoesntHave('courseEnrolled');
  //   }

  //   if ($request->course_filter == 'non-active') {
  //     $threeWeeksAgo = now()->subWeeks(3);
  //     $query->where('last_activation', '<', $threeWeeksAgo);
  //   }

  //   /*
  //   |----------------------------------
  //   | Date Filters (NEW)
  //   |----------------------------------
  //   */

  //   // Joined date
  //   if ($request->join_from && $request->join_to) {
  //     $query->whereBetween('created_at', [
  //       $request->join_from,
  //       $request->join_to
  //     ]);
  //   }

  //   // Last active date
  //   if ($request->active_from && $request->active_to) {
  //     $query->whereBetween('last_activation', [
  //       $request->active_from,
  //       $request->active_to
  //     ]);
  //   }

  //   /*
  //   |----------------------------------
  //   | Pagination
  //   |----------------------------------
  //   */
  //   $students = $query->latest()->paginate(10);

  //   /*
  //   |----------------------------------
  //   | AJAX Response
  //   |----------------------------------
  //   */
  //   if ($request->ajax()) {
  //     return view('company.students.table', compact('students'))->render();
  //   }

  //   return view('company.students.index', compact('students'));
  // }

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

    return redirect()->back();
    // return view('company.students.form');
  }

  public function store(Request $request)
  {

    $company_id = auth()->user()->company_id;
    DB::beginTransaction();

    $teachingSubjects = $request->input('preferable_subjects', []); // array
    $otherSubject = $request->input('other_subject'); // string

    // Merge into one array
    $allSubjects = $teachingSubjects;

    if ($request->filled('other_subject')) {
      if (!empty($otherSubject)) {
        $allSubjects[] = $otherSubject; // Add only if not null
      }

      $allSubjects = array_filter(array_merge(
        $request->input('preferable_subjects', []),
        [$request->input('other_subject')]
      ));
    }

    try {
      // 1️⃣  create User
      $student = User::create([
        'name'        => $request->name,
        'email'       => $request->email,
        'mobile'      => $request->phone,
        'acc_type'    => 'student',
        'address'     => $request->address,
        'city'        => $request->city,
        'postal_code' => $request->postal_code,
        'district'    => $request->district,
        'state'       => $request->state,
        'country'     => $request->country,
        'company_id'  => $company_id,
      ]);

      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = studentPersonalInfo::updateOrCreate(
        ['student_id' => $student->id],
        [
          'parent_name' => $request->parent_name,
          'study_mode' => $request->mode
        ]
      );


      // 3️⃣ Sync Working Days
      if ($request->filled('preferred_days')) {
        StudentAvailableDay::where('student_id', $student->id)->delete();
        foreach ($request->preferred_days as $day) {
          StudentAvailableDay::create([
            'student_id' => $student->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('preferred_hours')) {
        StudentAvailableHour::where('student_id', $student->id)->delete();
        foreach ($request->preferred_hours as $hour) {
          StudentAvailableHour::create([
            'student_id' => $student->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('preferable_grades')) {
        StudentGrade::where('student_id', $student->id)->delete();
        foreach ($request->preferable_grades as $grade) {
          StudentGrade::create([
            'student_id' => $student->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        StudentRecommendedSubject::where('student_id', $student->id)->delete();
        foreach ($allSubjects as $subject) {
          StudentRecommendedSubject::create([
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


      $student->status = $request->status ?? '1'; // default to active if not provided
      // 8️⃣ Mark profile as filled
      $student->profile_fill = 1;
      $student->save();


      DB::commit();

      return redirect()->route('company.students.index')->with('success', 'student created successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'student creation failed! ' . $e->getMessage());
    }
  }
  public function edit($id)
  {

    $user = User::with([
      'professionalInfo',
      'preferredDays',
      'preferredHours',
      'StudentGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'student')->first();

    if (!$user) {
      return response()->json(['message' => 'student not found'], 404);
    }

    return view('company.students.form', compact('user'));
  }

  public function update(Request $request, $id)
  {

    $student = User::where('id', $id)->where('acc_type', 'student')->first();

    if (!$student) {
      return response()->json(['message' => 'student not found'], 404);
    }

    DB::beginTransaction();
    $company_id = auth()->user()->company_id;

    $teachingSubjects = $request->input('preferable_subjects', []); // array
    $otherSubject = $request->input('other_subject'); // string

    // Merge into one array
    $allSubjects = $teachingSubjects;

    if ($request->filled('other_subject')) {
      if (!empty($otherSubject)) {
        $allSubjects[] = $otherSubject; // Add only if not null
      }

      $allSubjects = array_filter(array_merge(
        $request->input('preferable_subjects', []),
        [$request->input('other_subject')]
      ));
    }

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
      ]);

      // 2️⃣ Professional Info (updateOrCreate to avoid duplicates)
      $profInfo = studentPersonalInfo::updateOrCreate(
        ['student_id' => $student->id],
        [
          'parent_name' => $request->parent_name,
          'study_mode' => $request->mode
        ]
      );


      // 3️⃣ Sync Working Days
      if ($request->filled('preferred_days')) {
        StudentAvailableDay::where('student_id', $student->id)->delete();
        foreach ($request->preferred_days as $day) {
          StudentAvailableDay::create([
            'student_id' => $student->id,
            'day'        => trim($day),
          ]);
        }
      }

      // 4️⃣ Sync Working Hours
      if ($request->filled('preferred_hours')) {
        StudentAvailableHour::where('student_id', $student->id)->delete();
        foreach ($request->preferred_hours as $hour) {
          StudentAvailableHour::create([
            'student_id' => $student->id,
            'time_slot'  => trim($hour),
          ]);
        }
      }

      // 5️⃣ Sync Grades
      if ($request->filled('preferable_grades')) {
        StudentGrade::where('student_id', $student->id)->delete();
        foreach ($request->preferable_grades as $grade) {
          StudentGrade::create([
            'student_id' => $student->id,
            'grade'      => trim($grade),
          ]);
        }
      }

      // 6️⃣ Sync Subjects
      if ($allSubjects) {
        StudentRecommendedSubject::where('student_id', $student->id)->delete();
        foreach ($allSubjects as $subject) {
          StudentRecommendedSubject::create([
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

      // 8️⃣ Mark profile as filled
      $student->profile_fill = 1;

      $student->status = $request->status ?? $student->status;
      $student->save();

      DB::commit();

      return redirect()->route('company.students.index')->with('success', 'student updated successfully!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'student updation failed! ' . $e->getMessage());
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

      return redirect()->route('company.students.index')->with('success', 'student deleted successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with(['error', 'Failed to delete student' . $e->getMessage()]);
    }
  }

  public function studentDetails($id)
  {
    $company_id = auth()->user()->company_id;
    $student = User::where('id', $id)->where('company_id', $company_id)->first();

    // ================= OVERVIEW =================
    $overview = (object) [
      'courses' => $student->courseEnrolled?->count() ?? 0,
      'completed' => $student->courseEnrolled?->where('status', 'completed')->count() ?? 0,
      'pending' => $student->courseEnrolled?->where('status', 'pending')->count() ?? 0,
      'certificates' => $student->certificates?->count() ?? 0,

      'watch_time' => 0,
      'daily_avg' => 0,
      'last_active' => timeAgo($student->last_activation),

      'total_spent' => 0,
      'last_payment' => formatDateTime($student->payments?->last()?->created_at),
      'payment_mode' => $student->payments?->last()?->mode ?? '--',

      'score' => $student->myScore?->avg('score') ?? 0,
      'assignments' => $student->assignments?->count() ?? 0,
      'tests' => $student->tests?->count() ?? 0,

      'attendance' => $student->attendance?->count() ?? 0,
      'attended' => $student->attendance?->where('status', 'attended')->count() ?? 0,
      'missed' => $student->attendance?->where('status', 'missed')->count() ?? 0,

      'referrals' => $student->referrals?->count() ?? 0,
      'referral_bonus' => $student->referrals?->sum('bonus') ?? 0,

      'avg_rating' =>    0,
    ];

    // ================= COURSES =================
    $courses = CourseEnrollment::where('user_id', $student->id)
      ->get()
      ->map(function ($course) {
        $totalClasses = $course->course->classes->count();
        $completedClasses = $course->course->classes->where('status', 'completed')->count();
        $pendingClasses = $course->course->classes->where('status', 'pending')->count();
        return (object) [
          'title' => $course->course->title,
          'subject' => $course->course->subject->name ?? '',
          'type' => ucfirst($course->course->class_type) . '<br> (' . ucfirst($course->course->course_type) . ')',
          'is_renewable' => $course->is_renewable,
          'price' => $course->price,
          'discount' => $course->discount,
          'grand_total' => $course->final_price,
          'teachers' =>   $course->course->teachers->pluck('name')->join(', '),
          'status' => $course->status,
          'classes_completed' => $completedClasses,
          'classes_pending' => $pendingClasses,
          'classes_total' => $totalClasses,
          'joined_date' => $course->created_at,
          'start_date' => $course->start_date,
          'end_date' => $course->expiry_date,
        ];
      });

    $performance = (object) [
      'avg_activity' => 0,
      'completion_rate' => 0,
      'spend_time' => 0,
      'watch_time' => 0,
    ];



    $wallet = (object) [
      'total_earned' => 0,
      'balance' => 0,
      'withdrawn' => 0,
      'pending' => 0,
      'class_earnings' => 0,
      'referral_earnings' => 0,
      'bonus' => 0,
    ];

    $transactions = [
      // (object) [
      //   'date' => '10 Apr',
      //   'type' => 'credit',
      //   'category' => 'class',
      //   'sub_type' => 'live_class',
      //   'description' => 'Math Live Class Earnings',
      //   'amount' => 3000,
      //   'status' => 'completed',
      // ],
      // (object) [
      //   'date' => '09 Apr',
      //   'type' => 'credit',
      //   'category' => 'referral',
      //   'sub_type' => 'student_referral',
      //   'description' => 'Referral Bonus',
      //   'amount' => 500,
      //   'status' => 'completed',
      // ],
      // (object) [
      //   'date' => '08 Apr',
      //   'type' => 'credit',
      //   'category' => 'bonus',
      //   'sub_type' => 'performance',
      //   'description' => 'Top Performer Bonus',
      //   'amount' => 2000,
      //   'status' => 'completed',
      // ],
      // (object) [
      //   'date' => '07 Apr',
      //   'type' => 'debit',
      //   'category' => 'withdrawal',
      //   'sub_type' => 'bank_transfer',
      //   'description' => 'Withdrawal Request',
      //   'amount' => 4000,
      //   'status' => 'pending',
      // ],
    ];

    $paymentsSummary = (object) [
      'total_paid' => 0,
      'pending' => 0,
      'failed' => 0,
      'last_payout_date' => '',
    ];


    $payouts = [
      // (object) [
      //   'date' => '10 Apr',
      //   'amount' => 5000,
      //   'method' => 'Bank Transfer',
      //   'status' => 'pending',
      //   'reference' => 'PO12345',
      // ],
      // (object) [
      //   'date' => '05 Apr',
      //   'amount' => 8000,
      //   'method' => 'UPI',
      //   'status' => 'completed',
      //   'reference' => 'PO12344',
      // ],
    ];

    $payments = [
      // (object) [
      //   'date' => '05 Apr',
      //   'amount' => 8000,
      //   'type' => 'Payout',
      //   'status' => 'Success',
      //   'txn_id' => 'TXN999',
      // ],
    ];

    $activities = [
      // (object) [
      //   'title' => 'Logged in from mobile',
      //   'description' => 'Android device - Kerala',
      //   'type' => 'login',
      //   'time' => 'Today, 10:30 AM',
      // ],
      // (object) [
      //   'title' => 'Completed Algebra Class',
      //   'description' => 'Duration: 60 mins',
      //   'type' => 'class',
      //   'time' => 'Yesterday',
      // ],
      // (object) [
      //   'title' => 'Received Payment',
      //   'description' => '₹5000 credited',
      //   'type' => 'payment',
      //   'time' => '08 Apr 2026',
      // ],
      // (object) [
      //   'title' => 'Referred a student',
      //   'description' => 'Bonus ₹500 earned',
      //   'type' => 'referral',
      //   'time' => '07 Apr 2026',
      // ],
    ];

    $lastLogin = $student->last_login_at ? $student->last_login_at->format('d M Y, h:i A') : 'N/A';

    $logins = [
      // (object) [
      //   'date' => '12 Apr 2026, 10:30 AM',
      //   'ip' => '103.45.22.10',
      //   'device' => 'Android - Chrome',
      //   'location' => 'Kerala, India',
      //   'status' => 'safe',
      // ],
      // (object) [
      //   'date' => '11 Apr 2026, 08:15 PM',
      //   'ip' => '192.168.1.1',
      //   'device' => 'Windows - Chrome',
      //   'location' => 'Kerala, India',
      //   'status' => 'safe',
      // ],
      // (object) [
      //   'date' => '10 Apr 2026, 02:00 AM',
      //   'ip' => '85.23.11.9',
      //   'device' => 'Unknown Device',
      //   'location' => 'Unknown',
      //   'status' => 'suspicious',
      // ],
    ];



    $reviews = [
      // (object) [
      //   'student' => 'Rahul',
      //   'rating' => 5,
      //   'comment' => 'Excellent teaching style!',
      //   'course' => 'Algebra',
      //   'date' => '10 Apr 2026',
      // ],
      // (object) [
      //   'student' => 'Aisha',
      //   'rating' => 4,
      //   'comment' => 'Very helpful sessions',
      //   'course' => 'Physics',
      //   'date' => '08 Apr 2026',
      // ],
    ];

    return view('company.students.detailed-information', compact('student', 'overview', 'courses', 'performance', 'wallet', 'transactions', 'paymentsSummary', 'payouts', 'payments', 'activities', 'lastLogin', 'logins', 'reviews'));
  }
}
