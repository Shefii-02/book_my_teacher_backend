<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\CompanyTeacher;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TopBanner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
  public function home(Request $request)
  {

    $student = $request->user(); // frontend should send teacher_id
    $studentId = $student->id;

    $student = User::where('id', $studentId)
      ->where('acc_type', 'student')
      ->where('company_id', 1)
      ->first();

    if (!$student) {
      return response()->json([
        'message' => 'Student not found'
      ], 404);
    }


    // ✅ Get avatar & CV from MediaFile
    $avatar = MediaFile::where('user_id', $studentId)
      ->where('file_type', 'avatar')
      ->first();

    // ✅ Steps data as real array, not string
    $steps = [
      [
        "title"    => "Personal Info",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/personal-info",
        "allow"    => false,
      ],
      [
        "title"    => "Study Details",
        "subtitle" => "Completed",
        "status"   => "completed",
        "route"    => "/study-details",
        "allow"    => false,
      ],
      [
        "title"    => "Verification Process",
        "subtitle" => "In Progress",
        "status"   => "inProgress",
        "route"    => "/verification",
        "allow"    => false,
      ],
    ];

    return response()->json([
      'user'             => $student,
      'avatar'           => $avatar ? asset('storage/' . $avatar->file_path) : null,
      'steps'            => $steps,
    ]);
  }

  public function topBanners(Request $request): JsonResponse
  {
    $user = $request->user();
    $banners = TopBanner::with(['requestBanner' => function ($q) use ($user) {
      $q->where('user_id', $user->id);
    }])->where('banner_type', 'top-banner')->get();

    // $banners = collect(range(1, 3))->map(function ($i) {
    //   return [
    //     'id' => $i,
    //     'title' => "Top Banner $i",
    //     'main_image' => asset("assets/mobile-app/banners/tb-{$i}.png"),
    //     'thumb' => asset("assets/mobile-app/banners/tb-{$i}.png"),
    //     'description' => "This is banner $i description.",
    //     'priority_order' => $i,
    //     'banner_type' => $i % 2 ? 'image' : 'video',
    //     'cta_label' => 'Join Now',
    //     'cta_action' => '',
    //     'is_booked' => $i % 3 === 0,
    //     // 'is_booked' => true,
    //     'last_booked_at' => $i % 3 === 0 ? now()->subDays($i)->toDateTimeString() : null,
    //   ];
    // });

    return response()->json([
      'status' => true,
      'message' => 'Top banners fetched successfully',
      // 'data' =>  BannerResource::collection($banners),
      'data' => BannerResource::collection($banners)->additional([
        'user_id' => $user->id
      ])
    ]);
  }

  public function courseBanners(): JsonResponse
  {
    $banners = collect(range(1, 3))->map(function ($i) {
      return [
        'id' => $i,
        'title' => "Top Banner $i",
        'main_image' => asset("assets/mobile-app/banners/course-banner-{$i}.png"),
        'thumb' => asset("assets/mobile-app/banners/course-banner-{$i}.png"),
        'description' => "This is banner $i description.",
        'priority_order' => $i,
        'banner_type' => $i % 2 ? 'image' : 'video',
        'cta_label' => 'Join Now',
        'cta_action' => '',
        // 'is_booked' => $i % 3 === 0,
        'is_booked' => true,
        'last_booked_at' => $i % 3 === 0 ? now()->subDays($i)->toDateTimeString() : null,
      ];
    });

    return response()->json([
      'status' => true,
      'message' => 'Top banners fetched successfully',
      'data' => $banners
    ]);
  }

  public function teachersListing(): JsonResponse
  {
    $teachers = collect(range(1, 15))->map(function ($i) {
      return [
        'id' => $i,
        'thumb' => "https://cdn.app/teachers/{$i}_thumb.jpg",
        'main' => "https://cdn.app/teachers/{$i}_main.jpg",
        'name' => "Teacher $i",
        'grade_qualification' => 'M.Sc. Mathematics',
        'subjects' => ['Maths', 'Science'],
        'rating' => rand(40, 50) / 10,
        'ranking' => $i,
        'bio' => "Experienced teacher number $i.",
        'reviews_count' => rand(100, 500),
        'total_students' => rand(1000, 3000),
        'languages' => ['English', 'Hindi'],
        'price_per_hour' => rand(400, 800),
        'experience_years' => rand(3, 10),
        'certifications' => ['CBSE Certified'],
        'time_slots' => [
          'monday' => ['10:00-11:00', '15:00-16:00'],
          'tuesday' => ['09:00-10:00']
        ],
        'demo_class_link' => 'https://meet.app/demo' . $i,
      ];
    });

    return response()->json([
      'status' => true,
      'message' => 'Teachers list fetched successfully',
      'data' => $teachers
    ]);
  }
  public function gradesSubjects(): JsonResponse
  {
    $grades = collect(range(1, 5))->map(function ($i) {
      return [
        'title' => "Grade $i",
        'value' => "grade_$i",
        'icon' => "https://cdn.app/icons/grade_$i.png",
        'color_code' => '#FFD700',
        'difficulty_level' => 'medium',
        'syllabus_reference' => "CBSE Grade $i Syllabus",
        'position' => $i,
        'subjects' => collect(range(1, 3))->map(function ($j) {
          return [
            'title' => "Subject $j",
            'value' => "subject_$j",
            'icon' => "https://cdn.app/icons/sub$j.png",
            'color_code' => '#00ADEF',
            'difficulty_level' => 'medium',
            'syllabus_reference' => 'CBSE',
            'position' => $j
          ];
        })
      ];
    });
    return response()->json(['status' => true, 'data' => $grades]);
  }
  public function boardSyllabus(): JsonResponse
  {
    $boards = [
      [
        'name' => 'CBSE',
        'grades_covered' => ['Grade 1–12'],
        'subject_covered' => ['Maths', 'Science', 'English'],
        'logo' => 'https://cdn.app/cbse_logo.png',
        'curriculum_type' => 'National',
        'language_options' => ['English', 'Hindi']
      ],
      [
        'name' => 'ICSE',
        'grades_covered' => ['Grade 1–12'],
        'subject_covered' => ['Maths', 'Physics', 'Chemistry'],
        'logo' => 'https://cdn.app/icse_logo.png',
        'curriculum_type' => 'Private',
        'language_options' => ['English']
      ]
    ];
    return response()->json(['status' => true, 'data' => $boards]);
  }

  public function provideSubjects(): JsonResponse
  {
    $subjects = collect(range(1, 15))->map(function ($i) {
      return [
        'title' => "Subject $i",
        'value' => "subject_$i",
        'description' => "Description for subject $i",
        'booked_status' => $i % 2 === 0,
        'date' => now()->toDateString(),
        'icon' => "https://cdn.app/icons/sub_$i.png"
      ];
    });
    return response()->json(['status' => true, 'data' => $subjects]);
  }
  public function provideCourses(): JsonResponse
  {
    // $courses = collect(range(1, 15))->map(function ($i) {
    //   return [
    //     'title' => "Course $i",
    //     'value' => "course_$i",
    //     'description' => "Learn subject in depth $i",
    //     'booked_status' => $i % 3 === 0,
    //     'date' => now()->toDateString(),
    //     'total_enrollments' => rand(50, 300),
    //     'teacher_details' => [
    //       ['name' => 'Teacher A', 'rating' => 4.8, 'experience' => 8]
    //     ]
    //   ];
    // });
    // return response()->json(['status' => true, 'data' => $courses]);


    $courses = collect([
      [
        'id' => 1,
        'title' => 'Mathematics Basics',
        'description' => 'Learn core concepts of algebra, geometry, and arithmetic.',
        'category' => 'Course',
        'image' => asset('assets/mobile-app/courses/math.png'),
        'duration' => '3 Months',
        'level' => 'Beginner',
        'is_enrolled' => false,
      ],
      [
        'id' => 2,
        'title' => 'Science Fundamentals',
        'description' => 'Explore physics, chemistry, and biology principles.',
        'category' => 'Course',
        'image' => asset('assets/mobile-app/courses/science.png'),
        'duration' => '4 Months',
        'level' => 'Intermediate',
        'is_enrolled' => true,
      ],
      // [
      //   'id' => 3,
      //   'title' => 'AI for Beginners',
      //   'description' => 'Introduction to artificial intelligence and ML basics.',
      //   'category' => 'Workshop',
      //   'image' => asset('assets/mobile-app/workshops/ai.png'),
      //   'duration' => '2 Days',
      //   'level' => 'Skill Booster',
      //   'is_enrolled' => false,
      // ],
      // [
      //   'id' => 4,
      //   'title' => 'Web Development Bootcamp',
      //   'description' => 'Full-stack web development using Laravel & React.',
      //   'category' => 'Workshop',
      //   'image' => asset('assets/mobile-app/workshops/web.png'),
      //   'duration' => '5 Days',
      //   'level' => 'Advanced',
      //   'is_enrolled' => false,
      // ],
      [
        'id' => 5,
        'title' => 'Effective Communication Webinar',
        'description' => 'Boost your communication skills with real-time interaction.',
        'category' => 'Webinar',
        'image' => asset('assets/mobile-app/webinars/communication.png'),
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



  public function myClasses(): JsonResponse
  {
    $data = [
      'categories' => [
        [
          'category' => 'Courses',
          'sections' => [
            [
              'status' => 'Pending Approval',
              'items' => [
                [
                  'id' => 1,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'join_link' => null,
                ],
              ],
            ],
            [
              'status' => 'Ongoing',
              'items' => [
                [
                  'id' => 2,
                  'title' => 'Flutter App Development',
                  'description' => 'Learn Flutter with hands-on examples.',
                  'image' => asset('assets/mobile-app/banners/course-banner-2.png'),
                  'duration' => '4 weeks',
                  'level' => 'Beginner',
                  'join_link' => 'https://meet.google.com/abc-defg-hij',
                ],
              ],
            ],
            [
              'status' => 'Completed',
              'items' => [
                [
                  'id' => 3,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',
                  'join_link' => null,
                ],
              ],
            ],
          ],
        ],
        [
          'category' => 'Webinars',
          'sections' => [
            [
              'status' => 'Ongoing',
              'items' => [
                [
                  'id' => 4,
                  'title' => 'AI in Education Webinar',
                  'description' => 'Explore how AI impacts modern teaching.',
                  'image' => asset('assets/mobile-app/banners/webinar-banner-1.png'),
                  'duration' => '1 day',
                  'level' => 'All',
                  'join_link' => 'https://zoom.us/j/123456789',
                ],
              ],
            ],
          ],
        ],
        // [
        //   'category' => 'Workshops',
        //   'sections' => [
        //     [
        //       'status' => 'Completed',
        //       'items' => [
        //         [
        //           'id' => 5,
        //           'title' => 'Skill Booster: JavaScript Mastery',
        //           'description' => 'Hands-on coding sessions and challenges.',
        //           'image' => asset('assets/mobile-app/banners/workshop-banner-1.png'),
        //           'duration' => '2 days',
        //           'level' => 'Intermediate',
        //           'join_link' => null,
        //         ],
        //       ],
        //     ],
        //   ],
        // ],
      ],
    ];

    return response()->json([
      'status' => true,
      'message' => 'My classes fetched successfully',
      'data' => $data
    ]);
  }


  public function fetchClassDetail(Request $request): JsonResponse
  {
    $id = $request->courseId;

    // $classDetail = [
    //     'id' => $id,
    //     'title' => 'Flutter App Development Masterclass',
    //     'description' => 'Learn Flutter from scratch to advanced level with real-world projects and quizzes.',
    //     'image' => asset('assets/mobile-app/banners/course-banner-2.png'),
    //     'duration' => '4 weeks',
    //     'level' => 'Beginner',
    //     'category' => 'Courses',
    //     'join_type' => 'internal', // internal (Agora/Zego) or external (Google Meet, Zoom)
    //     'join_link' => 'https://meet.google.com/abc-defg-hij',
    // ];

    // $materials = [
    //     [
    //         'id' => 1,
    //         'title' => 'Introduction to Flutter',
    //         'file_name' => 'flutter_intro.pdf',
    //         'file_url' => asset('assets/materials/flutter_intro.pdf'),
    //         'type' => 'pdf',
    //     ],
    //     [
    //         'id' => 2,
    //         'title' => 'Widgets Deep Dive',
    //         'file_name' => 'widgets_deep_dive.pdf',
    //         'file_url' => asset('assets/materials/widgets_deep_dive.pdf'),
    //         'type' => 'pdf',
    //     ],
    //     [
    //         'id' => 3,
    //         'title' => 'Practical Demo Video',
    //         'file_name' => 'demo_video.mp4',
    //         'file_url' => asset('assets/materials/demo_video.mp4'),
    //         'type' => 'video',
    //     ],
    // ];

    // $classList = [
    //     [
    //         'id' => 101,
    //         'title' => 'Live Class 1: Flutter Basics',
    //         'status' => 'completed',
    //         'scheduled_at' => now()->subDays(3)->toDateTimeString(),
    //         'recording_url' => asset('assets/videos/flutter_basics_recorded.mp4'),
    //         'join_link' => null,
    //         'join_type' => null,
    //     ],
    //     [
    //         'id' => 102,
    //         'title' => 'Live Class 2: State Management',
    //         'status' => 'ongoing',
    //         'scheduled_at' => now()->subHour()->toDateTimeString(),
    //         'recording_url' => null,
    //         'join_link' => 'https://meet.google.com/abc-defg-hij',
    //         'join_type' => 'external',
    //     ],
    //     [
    //         'id' => 103,
    //         'title' => 'Live Class 3: Flutter Animations',
    //         'status' => 'upcoming',
    //         'scheduled_at' => now()->addDays(2)->toDateTimeString(),
    //         'recording_url' => null,
    //         'join_link' => null,
    //         'join_type' => null,
    //     ],
    // ];


    // Dummy class data
    $classDetail = [
      'id' => $id,
      'title' => 'Flutter Beginner Class',
      'description' => 'Learn Flutter from scratch — covering widgets, layouts, navigation, and API integration.',
      'teacher_name' => 'John Doe',
      'category' => 'Mobile Development',
      'price' => 499,
      'duration' => '8 weeks',
      'thumbnail' => asset('images/flutter_class.jpg'),
    ];

    // Dummy class materials
    $materials = [
      ['id' => 1, 'title' => 'Introduction to Flutter', 'file_url' => asset('materials/intro.pdf')],
      ['id' => 2, 'title' => 'Widgets Deep Dive', 'file_url' => asset('materials/widgets.pdf')],
    ];

    // Dummy related classes
    $classList = [
      ['id' => 101, 'title' => 'Flutter Intermediate', 'teacher' => 'Jane Smith'],
      ['id' => 102, 'title' => 'Dart Advanced Concepts', 'teacher' => 'Mark Allen'],
    ];

    return response()->json([
      'status' => true,
      'message' => 'Class details fetched successfully',
      'data' => [
        'class_detail' => $classDetail,
        'materials' => $materials,
        'classes' => $classList,
      ],
    ]);


    return response()->json([
      'status' => true,
      'message' => 'Class details fetched successfully',
      'data' => [
        'class_detail' => $classDetail,
        'materials' => $materials,
        'classes' => $classList,
      ],
    ]);
  }

  public function performance()
  {
    // Dummy response (you can replace with DB values later)
    $data = [
      "total_classes" => 50,
      "attended" => 42,
      "missed" => 8,
      "performance_percentage" => 84,
      "month_wise" => [
        ["month" => "Jan", "attended" => 15, "missed" => 2],
        ["month" => "Feb", "attended" => 12, "missed" => 1],
        ["month" => "Mar", "attended" => 15, "missed" => 5],
      ]
    ];

    return response()->json([
      "status" => true,
      "message" => "success",
      "data" => $data
    ], 200);
  }
}
