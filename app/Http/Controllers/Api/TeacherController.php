<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\CompanyTeacher;
use App\Models\MediaFile;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{

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
    // $profInfo     = \App\Models\TeacherProfessionalInfo::where('teacher_id', $teacherId)->first();
    // $workingDays  = \App\Models\TeacherWorkingDay::where('teacher_id', $teacherId)->pluck('day');
    // $workingHours = \App\Models\TeacherWorkingHour::where('teacher_id', $teacherId)->pluck('time_slot');
    // $grades       = \App\Models\TeacherGrade::where('teacher_id', $teacherId)->pluck('grade');
    // $subjects     = \App\Models\TeachingSubject::where('teacher_id', $teacherId)->pluck('subject');

    $accountStatusResponse = accountStatus($teacher);
    $accountMsg = $accountStatusResponse['accountMsg'];
    $steps = $accountStatusResponse['steps'];

    Log::info('User data retrieved', [
      'user' => (new UserResource($teacher, $accountMsg, $steps))->toArray(request()),
    ]);


    return response()->json([
      'user'              => new UserResource($teacher, $accountMsg, $steps),
      // 'account_msg'       => $accountStatusResponse['accountMsg'],
      // 'steps'             => $accountStatusResponse['steps'],
      // 'professional_info' => $profInfo,
      // 'working_days'      => $workingDays,
      // 'working_hours'     => $workingHours,
      // 'grades'            => $grades,
      // 'subjects'          => $subjects,
      // 'avatar'            => $teacher->avatar ? asset('storage/' . $teacher->avatar->file_path) : null,
      // 'cv_file'           => $teacher ? asset('storage/' . $teacher->cv->file_path) : null,

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
    Log::info("CV Updating");
    $user = $request->user();
    $company_id = 1;
    Log::info($request->all());
    try {
      if ($request->hasFile('cv_file')) {

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
        Log::info($cvPath);

        MediaFile::create([
          'user_id' => $user->id,
          'company_id' => $company_id,
          'file_type'  => 'cv', // ✅ FIXED
          'file_path'  => $cvPath, // ✅ FIXED
          'name'       => $file->getClientOriginalName(),
          'mime_type'  => $file->getMimeType(),
        ]);

        Log::info($cvPath);
        $user->save();
        DB::commit();
      }

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



  public function schedule(Request $request)
  {

    $month = now()->format('Y-m');

    // $start = Carbon::parse($month)->startOfMonth();
    // $end = Carbon::parse($month)->endOfMonth();

    $start = Carbon::parse($month)->subMonths(2)->startOfMonth();
    $end   = Carbon::parse($month)->addMonth(2)->endOfMonth();


    // 🔥 Dummy data — Replace with DB query later
    $dummyEvents = [
      "2025-11-10" => [
        [
          "id" => 1,
          "type" => "Individual Class",
          "topic" => "Basic Algebra Introduction",
          "description" => "Understanding variables, equations, and basic algebraic expressions.",
          "time_start" => "10:00",
          "time_end" => "11:00",
          "duration" => 60,
          "course_id" => 12,
          "class_link" => "https://zoom.us/abc123",
          "meeting_password" => "xyz123",
          "host_name" => "John Mathew",
          "class_status" => "upcoming",
          "attendance_required" => true,
          "subject_name" => "Mathematics",
          "thumbnail_url" => "https://example.com/thumb1.jpg",
          "class_type" => "online",
          "source" => "zoom",
          "location" => "Online",
          "students" => 10
        ],
        [
          "id" => 2,
          "type" => "Own Course Class",
          "topic" => "Chapter 5 - Heat & Temperature",
          "description" => "Explaining core physics concepts using real-life examples.",
          "time_start" => "14:00",
          "time_end" => "15:30",
          "duration" => 90,
          "course_id" => 4,
          "class_link" => null,
          "meeting_password" => null,
          "host_name" => "Teacher A",
          "class_status" => "completed",
          "attendance_required" => false,
          "subject_name" => "Physics",
          "thumbnail_url" => "https://example.com/thumb2.jpg",
          "class_type" => "offline",
          "location" => "Classroom A",
          "source" => "gmeet",
          "students" => 18
        ]
      ],

      "2025-11-12" => [
        [
          "id" => 5,
          "type" => "Webinar",
          "topic" => "Career Growth in Tech",
          "description" => "How to build your profile and get a tech job in 2025.",
          "time_start" => "18:00",
          "time_end" => "20:00",
          "duration" => 120,
          "course_id" => null,
          "class_link" => "https://meet.google.com/jkl987",
          "meeting_password" => "abc456",
          "host_name" => "Admin - BookMyTeacher",
          "class_status" => "live",
          "attendance_required" => false,
          "subject_name" => "General Guidance",
          "thumbnail_url" => "https://example.com/webinar.jpg",
          "class_type" => "online",
          "source" => "gmeet",
          "location" => "Online",
          "students" => 55
        ]
      ],

      "2025-11-15" => [
        [
          "id" => 9,
          "type" => "Workshop",
          "topic" => "Robotics Hands-on Workshop",
          "description" => "Practicals on assembling a beginner-level robot.",
          "time_start" => "11:00",
          "time_end" => "13:00",
          "duration" => 120,
          "course_id" => 10,
          "class_link" => null,
          "meeting_password" => null,
          "host_name" => "Dr. Reema",
          "class_status" => "upcoming",
          "attendance_required" => true,
          "subject_name" => "Robotics",
          "thumbnail_url" => "https://example.com/robotics.jpg",
          "class_type" => "hybrid",
          "source" => "",
          "location" => "Hall 2",
          "students" => 22
        ]
      ],
    ];


    return response()->json([
      "month" => $month,
      "first_day" => $start->toDateString(),
      "last_day" => $end->toDateString(),
      "events" => $dummyEvents,
    ]);
  }


  public function courses(Request $request)
  {
    Log::info($request->all());
    // Dummy data: replace with DB queries
    $upcoming = [
      [
        "id" => 11,
        "title" => "Flutter Basics",
        "thumbnail_url" => asset("assets/mobile-app/banners/course-banner-1.png"),
        "start_date" => "2025-11-20",
        "start_time" => "10:00 AM",
        "duration" => 60,
        "total_classes" => 20,
        "completed_classes" => 5
      ],
    ];

    $ongoing = [
      [
        "id" => 12,
        "title" => "React Native Live",
        "thumbnail_url" => asset("assets/mobile-app/banners/course-banner-2.png"),
        "start_date" => "2025-11-13",
        "start_time" => "01:00 PM",
        "duration" => 120,
        "total_classes" => 10,
        "completed_classes" => 3
      ],
    ];

    $completed = [
      [
        "id" => 13,
        "title" => "Python for Beginners",
        "thumbnail_url" => asset("assets/mobile-app/banners/course-banner-3.png"),
        "start_date" => "2025-11-10",
        "start_time" => "03:00 PM",
        "duration" => 90,
        "total_classes" => 12,
        "completed_classes" => 12
      ],
    ];

    return response()->json([
      'upcoming' => $upcoming,
      'ongoing' => $ongoing,
      'completed' => $completed,
    ]);
  }

  public function courseDetails(Request $request)
  {
    // Example dummy details per course id
    $course = [
      "id" => (int)$request->id,
      "title" => "React Native Live",
      "thumbnail_url" => asset("assets/mobile-app/banners/course-banner-1.png"),
      "description" => "Learn cross-platform development with React Native. Build real apps.",
      "duration" => "2 Months",
      "level" => "Intermediate",
      "language" => "English",
      "category" => "Mobile Development",
      "total_classes" => 20,
      "completed_classes" => 5
    ];

    $classes = [
      "upcoming" => [
        [
          "id" => 101,
          "title" => "Introduction to React Native",
          "date" => Carbon::parse('2025-11-16')->toDateString(),
          "time_start" => "10:00 AM",
          "time_end" => "11:00 AM",
          "class_status" => "upcoming"
        ],
      ],
      "ongoing" => [
        // none in dummy
      ],
      "completed" => [
        [
          "id" => 90,
          "title" => "JS Basics",
          "date" => Carbon::parse('2025-11-10')->toDateString(),
          "time_start" => "03:00 PM",
          "time_end" => "04:00 PM",
          "class_status" => "completed"
        ],
      ],
    ];

    $materials = [
      [
        "id" => 201,
        "title" => "Chapter 1 Notes",
        "file_url" => "https://example.com/files/ch1.pdf",
        "file_type" => "pdf"
      ],
      [
        "id" => 202,
        "title" => "UI Design Video",
        "file_url" => "https://example.com/files/ui.mp4",
        "file_type" => "video"
      ],
    ];

    return response()->json([
      "course" => $course,
      "classes" => $classes,
      "materials" => $materials,
    ]);
  }


  public function getStatistics(Request $request)
  {
    // Selected range (client can send ?range=Last 7 Days)
    $range = $request->get('range', 'Last 7 Days');

    $dummyData = $this->getDummyStatistics();

    return response()->json([
      "range"       => $range,
      "spend_time"  => $dummyData['spend'],
      "watch_time"  => $dummyData['watch'],
      "summary"     => [
        "total_spend" => "0 hrs",
        "total_watch" => "0 hrs"
      ],
    ]);
  }


  private function getDummyStatistics()
  {
    return [
      "spend" => [
        "Last 2 Days" => [
          "Individual"   => [5,1],
          "Own Courses"  => [3,2],
          "YouTube"      => [7,3],
          "Workshops"    => [2,5],
          "Webinar"      => [4,7],
        ],
        "Last 7 Days" => [
          "Individual"   => [3, 6, 8, 7, 10, 9, 12],
          "Own Courses"  => [2, 4, 5, 6, 7, 8, 9],
          "YouTube"      => [5, 7, 8, 10, 9, 11, 13],
          "Workshops"    => [1, 3, 2, 4, 3, 5, 4],
          "Webinar"      => [2, 3, 4, 5, 6, 7, 8],
        ],
        "Current Month" => [
          "Individual"   => $this->generateSeries(14, 3, 1.2),
          "Own Courses"  => $this->generateSeries(14, 2, 1.0),
          "YouTube"      => $this->generateSeries(14, 3, 1.5),
          "Workshops"    => $this->generateSeries(14, 1, 0.9),
          "Webinar"      => $this->generateSeries(14, 2, 1.3),
        ],
        "Last Month" => [
          "Individual"   => $this->generateSeries(30, 3, 0.9),
          "Own Courses"  => $this->generateSeries(30, 2, 0.8),
          "YouTube"      => $this->generateSeries(30, 3, 1.4),
          "Workshops"    => $this->generateSeries(30, 1, 0.7),
          "Webinar"      => $this->generateSeries(30, 2, 1.0),
        ],
      ],

      "watch" => [
        "Last 2 Days" => [
          "Individual"   => [2,5],
          "Own Courses"  => [4,6],
          "YouTube"      => [9,1],
          "Workshops"    => [3,9],
          "Webinar"      => [5,3],
        ],
        "Last 7 Days" => [
          "Individual"   => [4, 5, 6, 8, 7, 6, 9],
          "Own Courses"  => [3, 4, 5, 7, 6, 8, 10],
          "YouTube"      => [6, 9, 10, 12, 11, 13, 15],
          "Workshops"    => [2, 3, 4, 5, 6, 5, 7],
          "Webinar"      => [3, 5, 6, 8, 9, 10, 12],
        ],
        "Current Month" => [
          "Individual"   => $this->generateSeries(14, 2, 1.1),
          "Own Courses"  => $this->generateSeries(14, 2, 1.3),
          "YouTube"      => $this->generateSeries(14, 3, 1.8),
          "Workshops"    => $this->generateSeries(14, 1, 1.0),
          "Webinar"      => $this->generateSeries(14, 2, 1.4),
        ],
        "Last Month" => [
          "Individual"   => $this->generateSeries(30, 3, 1.1),
          "Own Courses"  => $this->generateSeries(30, 2, 1.2),
          "YouTube"      => $this->generateSeries(30, 3, 1.6),
          "Workshops"    => $this->generateSeries(30, 1, 0.9),
          "Webinar"      => $this->generateSeries(30, 2, 1.3),
        ],
      ],
    ];
  }


  private function generateSeries($count, $base, $multiplier)
  {
    $list = [];
    for ($i = 0; $i < $count; $i++) {
      $list[] = ($i + $base) * $multiplier;
    }
    return $list;
  }


  public function reviews(Request $request)
  {

    return response()->json([
      "courses" => [
        [
          "course_id" => 1,
          "course_name" => "Flutter Basics",
          "average_rating" => 4.5,
          "total_reviews" => 2,
          "reviews" => [
            [
              "student" => "Alice",
              "rating" => 5.0,
              "comment" => "Excellent!",
              "date" => "2025-11-10",
            ],
            [
              "student" => "Bob",
              "rating" => 4.0,
              "comment" => "Very helpful",
              "date" => "2025-11-11",
            ],
          ]
        ],
        [
          "course_id" => 2,
          "course_name" => "Laravel Advanced",
          "average_rating" => 4.2,
          "total_reviews" => 2,
          "reviews" => [
            [
              "student" => "Charlie",
              "rating" => 4.5,
              "comment" => "Good explanations",
              "date" => "2025-11-12",
            ],
            [
              "student" => "David",
              "rating" => 4.0,
              "comment" => "Learned a lot",
              "date" => "2025-11-13",
            ],
          ]
        ],
        [
          "course_id" => 3,
          "course_name" => "MEAN STACK",
          "average_rating" => 4.8,
          "total_reviews" => 10,
          "reviews" => [
            [
              "student" => "Charlie",
              "rating" => 4.5,
              "comment" => "Good explanations",
              "date" => "2025-11-12",
            ],
            [
              "student" => "David",
              "rating" => 4.0,
              "comment" => "Learned a lot",
              "date" => "2025-11-13",
            ],
            [
              "student" => "Charlie",
              "rating" => 4.5,
              "comment" => "Good explanations",
              "date" => "2025-11-12",
            ],
            [
              "student" => "David",
              "rating" => 4.0,
              "comment" => "Learned a lot",
              "date" => "2025-11-13",
            ],
            [
              "student" => "Charlie",
              "rating" => 4.5,
              "comment" => "Good explanations",
              "date" => "2025-11-12",
            ],
            [
              "student" => "David",
              "rating" => 4.0,
              "comment" => "Learned a lot",
              "date" => "2025-11-13",
            ],
            [
              "student" => "Charlie",
              "rating" => 4.5,
              "comment" => "Good explanations",
              "date" => "2025-11-12",
            ],
            [
              "student" => "David",
              "rating" => 4.0,
              "comment" => "Learned a lot",
              "date" => "2025-11-13",
            ],
            [
              "student" => "Charlie",
              "rating" => 4.5,
              "comment" => "Good explanations",
              "date" => "2025-11-12",
            ],
            [
              "student" => "David",
              "rating" => 4.0,
              "comment" => "Learned a lot",
              "date" => "2025-11-13",
            ],
          ]
        ]
      ]
    ]);
  }

  public function fetchingReviews(Request $request)
  {
    $reviews = [
      [
        "name" => "Aisha Patel",
        "review" => "Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.",
        "image" => "https://i.pravatar.cc/150?img=5",
        "rating" => 4.5,
      ],
      [
        "name" => "Rahul Sharma",
        "review" => "Helpful and patient during sessions.",
        "image" => "https://i.pravatar.cc/150?img=12",
        "rating" => 5.0,
      ],
      [
        "name" => "Sneha R.",
        "review" => "Good teaching but classes sometimes run late.",
        "image" => "https://i.pravatar.cc/150?img=8",
        "rating" => 3.5,
      ],
      [
        "name" => "Kevin Thomas",
        "review" => "Very friendly and made learning fun!",
        "image" => "https://i.pravatar.cc/150?img=14",
        "rating" => 4.0,
      ],
      // Add the rest...
    ];

    return response()->json([
      "status" => true,
      "reviews" => $reviews
    ]);
  }



  public function achievements()
  {
    return response()->json([
      "levels" => [
        [
          "level" => 1,
          "is_unlocked" => true,
          "progress" => 1.0,
          "points_remaining" => 0,
          "tasks" => [
            ["title" => "Complete 5 classes", "status" => "completed"],
            ["title" => "Earn 20 reward points", "status" => "completed"],
          ]
        ],
        [
          "level" => 2,
          "is_unlocked" => true,
          "progress" => 0.65,
          "points_remaining" => 400,
          "tasks" => [
            ["title" => "Teach 10 students", "status" => "ongoing"],
            ["title" => "Maintain 4.5 rating", "status" => "ongoing"],
          ]
        ],
        [
          "level" => 3,
          "is_unlocked" => false,
          "progress" => 0.0,
          "points_remaining" => 1200,
          "tasks" => [
            ["title" => "Complete 50 classes", "status" => "pending"],
            ["title" => "Get 100 reviews", "status" => "pending"],
          ]
        ]
      ]
    ]);
  }





  public function spendTime()
  {
    return response()->json([
      "data" => [
        [
          "title" => "Individual Class’s",
          "icon"  => "assets/images/icons/chart-1.png",
          "time"  => "31.4 hr"
        ],
        [
          "title" => "Own Course Class’s",
          "icon"  => "assets/images/icons/chart-2.png",
          "time"  => "22.8 hr"
        ],
        [
          "title" => "Youtube Class’s",
          "icon"  => "assets/images/icons/chart-3.png",
          "time"  => "15.1 hr"
        ],
      ]
    ]);
  }

  public function spendTimeStats()
  {
    $data = [
      "Last Day" => [
        "Individual" => [5.4],
        "Own Courses" => [3, 5],
        "YouTube" => [7, 2],
        "Workshops" => [2, 5],
        "Webinar" => [4, 6]
      ],
      "Last 7 Days" => [
        "Individual" => [3, 6, 8, 7, 10, 9, 12],
        "Own Courses" => [2, 4, 5, 6, 7, 8, 9],
        "YouTube" => [5, 7, 8, 10, 9, 11, 13],
        "Workshops" => [1, 3, 2, 4, 3, 5, 4],
        "Webinar" => [2, 3, 4, 5, 6, 7, 8]
      ]
    ];

    return response()->json($data);
  }

  public function watchTime()
  {
    return response()->json([
      "data" => [
        [
          "title" => "Individual Class’s",
          "icon"  => "assets/images/icons/chart-4.png",
          "time"  => "31.4 hr"
        ],
        [
          "title" => "Own Course Class’s",
          "icon"  => "assets/images/icons/chart-5.png",
          "time"  => "22.8 hr"
        ],
        [
          "title" => "Youtube Class’s",
          "icon"  => "assets/images/icons/chart-6.png",
          "time"  => "15.1 hr"
        ],
      ]
    ]);
  }
  public function watchTimeStats()
  {
    $data = [
      "Last Day" => [
        "Individual" => [5.4],
        "Own Courses" => [3, 5],
        "YouTube" => [7, 2],
        "Workshops" => [2, 5],
        "Webinar" => [4, 6]
      ],
      "Last 7 Days" => [
        "Individual" => [3, 6, 8, 7, 10, 9, 12],
        "Own Courses" => [2, 4, 5, 6, 7, 8, 9],
        "YouTube" => [5, 7, 8, 10, 9, 11, 13],
        "Workshops" => [1, 3, 2, 4, 3, 5, 4],
        "Webinar" => [2, 3, 4, 5, 6, 7, 8]
      ]
    ];

    return response()->json($data);
  }


  public function achievementLevel()
  {
    return response()->json([
      'status' => true,
      'message' => 'Achievement level fetched',
      'data' => [
        'current_level' => 2,
        'current_points' => 2200,
        'next_level' => 3,
        'points_to_reach_next' => 6000,
        'points_needed_for_next' => 3800, // 6000 - 5200
        'tasks' => [
          ['title' => 'Complete Daily Practice', 'completed' => true],
          ['title' => 'Attend Live Class', 'completed' => false],
        ]
      ]
    ]);
  }


  public function ownCourses()
  {

    $courses = collect([
      [
        'id' => 1,
        'title' => 'Mathematics Basics',
        'description' => 'Learn core concepts of algebra, geometry, and arithmetic.',
        'category' => 'Course',
        'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
        'duration' => '3 Months',
        'level' => 'Beginner',
        'is_enrolled' => false,
      ],
      [
        'id' => 2,
        'title' => 'Science Fundamentals',
        'description' => 'Explore physics, chemistry, and biology principles.',
        'category' => 'Course',
        'image' => asset('/assets/mobile-app/banners/course-banner-2.png'),
        'duration' => '4 Months',
        'level' => 'Intermediate',
        'is_enrolled' => true,
      ],
      [
        'id' => 3,
        'title' => 'AI for Beginners',
        'description' => 'Introduction to artificial intelligence and ML basics.',
        'category' => 'Workshop',
        'image' => asset('/assets/mobile-app/banners/course-banner-1.png'),
        'duration' => '2 Days',
        'level' => 'Skill Booster',
        'is_enrolled' => false,
      ],
      [
        'id' => 4,
        'title' => 'Web Development Bootcamp',
        'description' => 'Full-stack web development using Laravel & React.',
        'category' => 'Workshop',
        'image' => asset('/assets/mobile-app/banners/course-banner-2.png'),
        'duration' => '5 Days',
        'level' => 'Advanced',
        'is_enrolled' => false,
      ],
      [
        'id' => 5,
        'title' => 'Effective Communication Webinar',
        'description' => 'Boost your communication skills with real-time interaction.',
        'category' => 'Webinar',
        'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
        'duration' => '1 Hour',
        'level' => 'Open for All',
        'is_enrolled' => false,
        'schedule' => now()->addDays(3)->toDateTimeString(),
      ],
    ]);

    $grouped = $courses->groupBy('category')->map(function ($items, $category) {
      return [
        'category' => $category,
        'items' => $items->values(),
      ];
    })->values();

    return response()->json([
      'status' => true,
      'message' => 'Courses categorized successfully',
      'data' => $grouped,
    ]);
  }


  public function  performance(Request $request)
  {
    $teacher = $request->user(); // Authenticated teacher
    $filter  = $request->query('filter', 'daily'); // daily, weekly, monthly

    // DUMMY DATA (replace with DB queries)
    $dummyData = [
      'daily' => [
        'watch_time'     => '2.5 hrs',
        'students'       => 12,
        'avg_rating'     => 4.6,
        'growth'         => '+3%',
        'sessions'       => 4,
        'chart'          => [20, 35, 40, 50, 45, 30, 25],
        'labels'         => ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
      ],

      'weekly' => [
        'watch_time'     => '17 hrs',
        'students'       => 58,
        'avg_rating'     => 4.7,
        'growth'         => '+9%',
        'sessions'       => 18,
        'chart'          => [95, 120, 110, 140],
        'labels'         => ["Week 1", "Week 2", "Week 3", "Week 4"],
      ],

      'monthly' => [
        'watch_time'     => '72 hrs',
        'students'       => 240,
        'avg_rating'     => 4.8,
        'growth'         => '+14%',
        'sessions'       => 76,
        'chart'          => [280, 320, 300],
        'labels'         => ["Jan", "Feb", "Mar"],
      ],
    ];

    return response()->json([
      'status' => true,
      'filter' => $filter,
      'summary' => [
        'watch_time' => $dummyData[$filter]['watch_time'],
        'students'   => $dummyData[$filter]['students'],
        'avg_rating' => $dummyData[$filter]['avg_rating'],
        'growth'     => $dummyData[$filter]['growth'],
        'sessions'   => $dummyData[$filter]['sessions'],
      ],
      'chart' => [
        'labels' => $dummyData[$filter]['labels'],
        'values' => $dummyData[$filter]['chart'],
      ]
    ]);
  }
}
