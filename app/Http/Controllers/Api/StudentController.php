<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\CourseResource;
use App\Http\Resources\API\WorkshopResource;
use App\Http\Resources\API\WebinarResource;
use App\Http\Resources\API\BannerResource;
use App\Http\Resources\API\ClassLinkResource;
use App\Http\Resources\API\MaterialResource;
use App\Http\Resources\API\WebinarClassLinkResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Models\CompanyTeacher;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\DemoClass;
use App\Models\MediaFile;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TopBanner;
use App\Models\User;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Carbon\Carbon;
use Google\Service\Classroom\Material;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    // $banners = TopBanner::with(['requestBanner' => function ($q) use ($user) {
    //   $q->where('user_id', $user->id);
    // }])->where('banner_type', 'top-banner')->get();

    $banners = TopBanner::with([
      'requestBanner' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      },
      'course',
      'workshop',
      'webinar'
    ])->where('banner_type', 'top-banner')->get();


    return response()->json([
      'status' => true,
      'message' => 'Top banners fetched successfully',
      'data' => BannerResource::collection($banners)->additional([
        'user_id' => $user->id
      ])
    ]);
  }

  public function courseBanners(Request $request): JsonResponse
  {
    $user = $request->user();
    $banners = TopBanner::with(['requestBanner' => function ($q) use ($user) {
      $q->where('user_id', $user->id);
    }])->where('banner_type', 'course-banner')->get();

    return response()->json([
      'status' => true,
      'message' => 'Course banners fetched successfully',
      'data' => BannerResource::collection($banners)->additional([
        'user_id' => $user->id
      ])
    ]);
  }

  public function teachersListing(): JsonResponse
  {
    $teachers = Teacher::whereHas('topTeacher')->with(['reviews', 'courses', 'selectedSubjects'])->get();

    // $data = [
    //   [
    //     'id' => 1,
    //     'name' => 'Asif T',
    //     'qualification' => 'MCA, NET',
    //     'subjects' => 'Computer Science, English',
    //     'courses' => 'Spoken English, Jim',
    //     'ranking' => 1,
    //     'rating' => 4.8,
    //     'imageUrl' => asset('assets/mobile-app/asit-t.png'),
    //     'description' => 'Highly experienced computer science teacher with passion for modern learning.',
    //     'reviews' => [
    //       [
    //         'name' => 'Student 1',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
    //         'comment' => 'Very helpful sessions!',
    //         'rating' => 5
    //       ],
    //       [
    //         'name' => 'Student 2',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
    //         'comment' => 'Explains concepts clearly.',
    //         'rating' => 4
    //       ],
    //     ]
    //   ],
    //   [
    //     'id' => 2,
    //     'name' => 'James M',
    //     'qualification' => 'B.Ed, M.Sc',
    //     'subjects' => 'Maths, Physics',
    //     'courses' => 'Spoken English, Jim',
    //     'ranking' => 2,
    //     'rating' => 4.5,
    //     'imageUrl' => asset('assets/mobile-app/asit-t.png'),
    //     'description' => 'Highly experienced computer science teacher with passion for modern learning.',
    //     'reviews' => [
    //       [
    //         'name' => 'Student 1',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
    //         'comment' => 'Very helpful sessions!',
    //         'rating' => 5
    //       ],
    //       [
    //         'name' => 'Student 2',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
    //         'comment' => 'Explains concepts clearly.',
    //         'rating' => 4
    //       ],
    //     ]
    //   ],
    //   [
    //     'id' => 3,
    //     'name' => 'Sana K',
    //     'qualification' => 'B.Tech, M.Tech',
    //     'subjects' => 'Chemistry, Biology',
    //     'courses' => 'Spoken English, Jim',
    //     'ranking' => 3,
    //     'rating' => 4.7,
    //     'imageUrl' => asset('assets/mobile-app/asit-t.png'),
    //     'description' => 'Highly experienced computer science teacher with passion for modern learning.',
    //     'reviews' => [
    //       [
    //         'name' => 'Student 1',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
    //         'comment' => 'Very helpful sessions!',
    //         'rating' => 5
    //       ],
    //       [
    //         'name' => 'Student 2',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
    //         'comment' => 'Explains concepts clearly.',
    //         'rating' => 4
    //       ],
    //     ]
    //   ],
    //   [
    //     'id' => 4,
    //     'name' => 'Mohammed S',
    //     'qualification' => 'PhD, M.Ed',
    //     'subjects' => 'History, Civics',
    //     'courses' => 'Spoken English, Jim',
    //     'ranking' => 4,
    //     'rating' => 4.9,
    //     'imageUrl' => asset('assets/mobile-app/asit-t.png'),
    //     'description' => 'Highly experienced computer science teacher with passion for modern learning.',
    //     'reviews' => [
    //       [
    //         'name' => 'Student 1',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
    //         'comment' => 'Very helpful sessions!',
    //         'rating' => 5
    //       ],
    //       [
    //         'name' => 'Student 2',
    //         'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
    //         'comment' => 'Explains concepts clearly.',
    //         'rating' => 4
    //       ],
    //     ]
    //   ]
    // ];
    return response()->json([
      'message' => 'Teachers Fetached successfully',
      'data' => TeacherResource::collection($teachers),
      'status' => true
    ]);
    // $teachers = collect(range(1, 15))->map(function ($i) {
    //   return [
    //     'id' => $i,
    //     'thumb' => "https://cdn.app/teachers/{$i}_thumb.jpg",
    //     'main' => "https://cdn.app/teachers/{$i}_main.jpg",
    //     'name' => "Teacher $i",
    //     'grade_qualification' => 'M.Sc. Mathematics',
    //     'subjects' => ['Maths', 'Science'],
    //     'rating' => rand(40, 50) / 10,
    //     'ranking' => $i,
    //     'bio' => "Experienced teacher number $i.",
    //     'reviews_count' => rand(100, 500),
    //     'total_students' => rand(1000, 3000),
    //     'languages' => ['English', 'Hindi'],
    //     'price_per_hour' => rand(400, 800),
    //     'experience_years' => rand(3, 10),
    //     'certifications' => ['CBSE Certified'],
    //     'time_slots' => [
    //       'monday' => ['10:00-11:00', '15:00-16:00'],
    //       'tuesday' => ['09:00-10:00']
    //     ],
    //     'demo_class_link' => 'https://meet.app/demo' . $i,
    //   ];
    // });

    // return response()->json([
    //   'status' => true,
    //   'message' => 'Teachers list fetched successfully',
    //   'data' => $teachers
    // ]);
  }


  public function subjectsListing(): JsonResponse
  {
    $subjects = Subject::with([
      'reviews:user_id,subject_id,comments,rating',
      'courses:id,subject_id,title,main_image',
      'providingTeachers.teacher',
      'providingTeachers.teacher.selectedSubjects'

    ])->whereHas('providingSubjects')
      ->whereHas('providingTeachers')
      ->orderBy('position')
      ->where('published', 1)
      ->get();

    return response()->json([
      'status' => true,
      'message' => 'Subjects fetched successfully',
      'data' => SubjectResource::collection($subjects),
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
  public function courseStore(Request $request): JsonResponse
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

    $user = $request->user();

    // $courses = collect([
    //   [
    //     'id' => 1,
    //     'title' => 'Mathematics Basics',
    //     'description' => 'Learn core concepts of algebra, geometry, and arithmetic.',
    //     'category' => 'Course',
    //     'image' => asset('assets/mobile-app/courses/math.png'),
    //     'duration' => '3 Months',
    //     'level' => 'Beginner',
    //     'is_enrolled' => false,
    //   ],
    //   [
    //     'id' => 2,
    //     'title' => 'Science Fundamentals',
    //     'description' => 'Explore physics, chemistry, and biology principles.',
    //     'category' => 'Course',
    //     'image' => asset('assets/mobile-app/courses/science.png'),
    //     'duration' => '4 Months',
    //     'level' => 'Intermediate',
    //     'is_enrolled' => true,
    //   ],
    //   // [
    //   //   'id' => 3,
    //   //   'title' => 'AI for Beginners',
    //   //   'description' => 'Introduction to artificial intelligence and ML basics.',
    //   //   'category' => 'Workshop',
    //   //   'image' => asset('assets/mobile-app/workshops/ai.png'),
    //   //   'duration' => '2 Days',
    //   //   'level' => 'Skill Booster',
    //   //   'is_enrolled' => false,
    //   // ],
    //   // [
    //   //   'id' => 4,
    //   //   'title' => 'Web Development Bootcamp',
    //   //   'description' => 'Full-stack web development using Laravel & React.',
    //   //   'category' => 'Workshop',
    //   //   'image' => asset('assets/mobile-app/workshops/web.png'),
    //   //   'duration' => '5 Days',
    //   //   'level' => 'Advanced',
    //   //   'is_enrolled' => false,
    //   // ],
    //   [
    //     'id' => 5,
    //     'title' => 'Effective Communication Webinar',
    //     'description' => 'Boost your communication skills with real-time interaction.',
    //     'category' => 'Webinar',
    //     'image' => asset('assets/mobile-app/webinars/communication.png'),
    //     'duration' => '1 Hour',
    //     'level' => 'Open for All',
    //     'is_enrolled' => false,
    //     'schedule' => now()->addDays(3)->toDateTimeString(),
    //   ],
    // ]);

    // $grouped = $courses->groupBy('category')->map(function ($items, $category) {
    //   return [
    //     'category' => $category,
    //     'items' => $items->values(),
    //   ];
    // })->values();


    // $courses = Course::where('company_id',1)->get()
    //     ->map(function ($item) {
    //         $item->is_enrolled = false; // or dynamic check
    //         return $item;
    //     });

    // $webinars = Webinar::where('company_id',1)->whereIn('status',['scheduled','completed'])->get()
    //     ->map(function ($item) {
    //         $item->is_enrolled = false;
    //         return $item;
    //     });

    // $workshops = Workshop::where('company_id',1)->get()
    //     ->map(function ($item) {
    //         $item->is_enrolled = false;
    //         return $item;
    //     });

    // $data = collect([
    //     [
    //         'category' => 'Course',
    //         'items' => $courses,
    //     ],
    //     [
    //         'category' => 'Webinar',
    //         'items' => $webinars,
    //     ],
    //     [
    //         'category' => 'Workshop',
    //         'items' => $workshops,
    //     ],
    // ])->filter(fn ($group) => $group['items']->isNotEmpty())
    //   ->values();

    $courses = Course::with('institute')
      ->where('company_id', 1)
      ->where('is_public', 1)
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      // ->map(fn($c) => tap($c)->is_enrolled = false);
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });



    $webinars = Webinar::where('company_id', 1)
      ->whereIn('status', ['scheduled', 'completed'])
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });


    // ->map(fn($w) => tap($w)->is_enrolled = false);

    $workshops = Workshop::where('company_id', 1)
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });
    // ->map(fn($w) => tap($w)->is_enrolled = false);


    $data = collect([
      [
        'category' => 'Workshop',
        'items'    => WorkshopResource::collection($workshops),
      ],
      [
        'category' => 'Course',
        'items'    => CourseResource::collection($courses),
      ],
      [
        'category' => 'Webinar',
        'items'    => WebinarResource::collection($webinars),
      ]

    ])->filter(fn($g) => $g['items']->isNotEmpty())
      ->values();

    return response()->json([
      'status' => true,
      'message' => 'Courses categorized successfully',
      'data' => $data,
    ]);
  }



  public function myClasses(Request $request): JsonResponse
  {
    $user = $request->user();
    $today = Carbon::today();

    $sections = [
      'Ongoing' => [],
      'Completed' => [],
      'Pending Started Courses' => [],
      'Pending Approval' => [],
    ];

    // 🔹 Mapper
    $mapItem = function ($model, $type) {
      return [
        'id'          => $model->id,
        'title'       => $model->title,
        'description' => $model->description,
        'image'       => $model->banner_image ?? null,
        'duration'    => $model->duration ?? null,
        'level'       => $model->level ?? null,
        'type'        => $type,
        'join_link'   => $model->join_link ?? null,
      ];
    };

    /**
     * --------------------------------
     * WEBINARS
     * --------------------------------
     */
    WebinarRegistration::with('webinar')
      ->where('user_id', $user->id)
      ->get()
      ->each(function ($reg) use (&$sections, $today, $mapItem) {

        if (!$reg->webinar) return;

        $webinar = $reg->webinar;

        // if ($reg->checked_in == 0) {
        //   $sections['Pending Approval'][] = $mapItem($webinar, 'webinar');
        //   return;
        // }

        if ($webinar->started_at > $today) {
          $sections['Pending Started Courses'][] = $mapItem($webinar, 'webinar');
          return;
        }

        if ($webinar->started_at <= $today && $webinar->ended_at >= $today) {
          $sections['Ongoing'][] = $mapItem($webinar, 'webinar');
          return;
        }


        if ($webinar->ended_at < $today) {
          $sections['Completed'][] = $mapItem($webinar, 'webinar');
        }
      });

    /**
     * --------------------------------
     * COURSES
     * --------------------------------
     */
    CourseRegistration::with('course')
      ->where('user_id', $user->id)
      ->get()
      ->each(function ($reg) use (&$sections, $today, $mapItem) {

        if (!$reg->course) return;

        $course = $reg->course;

        // if ($reg->checked_in == 0) {
        //   $sections['Pending Approval'][] = $mapItem($course, 'course');
        //   return;
        // }

        if ($course->start_date > $today) {
          $sections['Pending Started Courses'][] = $mapItem($course, 'course');
          return;
        }

        if ($course->start_date <= $today && $course->end_date >= $today) {
          $sections['Ongoing'][] = $mapItem($course, 'course');
          return;
        }

        if ($course->end_date < $today) {
          $sections['Completed'][] = $mapItem($course, 'course');
        }
      });

    /**
     * --------------------------------
     * WORKSHOPS
     * --------------------------------
     */
    WorkshopRegistration::with('workshop')
      ->where('user_id', $user->id)
      ->get()
      ->each(function ($reg) use (&$sections, $today, $mapItem) {

        if (!$reg->workshop) return;

        $workshop = $reg->workshop;

        // if ($reg->checked_in == 0) {
        //   $sections['Pending Approval'][] = $mapItem($workshop, 'workshop');
        //   return;
        // }

        if ($workshop->started_at > $today) {
          $sections['Pending Started Courses'][] = $mapItem($workshop, 'workshop');
          return;
        }

        if ($workshop->started_at <= $today && $workshop->ended_at >= $today) {
          $sections['Ongoing'][] = $mapItem($workshop, 'workshop');
          return;
        }

        if ($workshop->ended_at < $today) {
          $sections['Completed'][] = $mapItem($workshop, 'workshop');
        }
      });

    Log::info($sections);

    return response()->json([
      'status'  => true,
      'message' => 'My classes fetched successfully',
      'data' => [
        'categories' => [
          [
            'sections' => collect($sections)->map(function ($items, $status) {
              return [
                'status' => $status,
                'items'  => array_values($items),
              ];
            })->values()
          ]
        ]
      ]
    ]);
  }


  public function myClasses2(): JsonResponse
  {
    $data = [
      'categories' => [
        [
          // 'category' => 'Courses',
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
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 2,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 3,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 4,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'webinar',
                  'join_link' => null,
                ],
                [
                  'id' => 5,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'webinar',
                  'join_link' => null,
                ],
                [
                  'id' => 6,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'webinar',
                  'join_link' => null,
                ],
                [
                  'id' => 7,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 8,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 9,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 10,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'webinar',
                  'join_link' => null,
                ],
                [
                  'id' => 11,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',

                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 12,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',

                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 13,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'webinar',
                  'join_link' => null,
                ],
                [
                  'id' => 14,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 15,
                  'title' => 'Advanced Laravel Bootcamp',
                  'description' => 'Master Laravel 11 with projects.',
                  'image' => asset('assets/mobile-app/banners/course-banner-1.png'),
                  'duration' => '6 weeks',
                  'level' => 'Intermediate',
                  'type'  => 'course',
                  'join_link' => null,
                ],
              ],
            ],
            [
              'status' => 'Pending Started Courses',
              'items' => []
            ],
            [
              'status' => 'Ongoing',
              'items' => [
                [
                  'id' => 17,
                  'title' => 'Flutter App Development',
                  'description' => 'Learn Flutter with hands-on examples.',
                  'image' => asset('assets/mobile-app/banners/course-banner-2.png'),
                  'duration' => '4 weeks',
                  'level' => 'Beginner',
                  'type'  => 'webinar',
                  'join_link' => 'https://meet.google.com/abc-defg-hij',
                ],
                [
                  'id' => 18,
                  'title' => 'Flutter App Development',
                  'description' => 'Learn Flutter with hands-on examples.',
                  'image' => asset('assets/mobile-app/banners/course-banner-2.png'),
                  'duration' => '4 weeks',
                  'level' => 'Beginner',
                  'type'  => 'course',
                  'join_link' => 'https://meet.google.com/abc-defg-hij',
                ],
                [
                  'id' => 19,
                  'title' => 'Flutter App Development',
                  'description' => 'Learn Flutter with hands-on examples.',
                  'image' => asset('assets/mobile-app/banners/course-banner-2.png'),
                  'duration' => '4 weeks',
                  'level' => 'Beginner',

                  'type'  => 'course',
                  'join_link' => 'https://meet.google.com/abc-defg-hij',
                ],
                [
                  'id' => 20,
                  'title' => 'Flutter App Development',
                  'description' => 'Learn Flutter with hands-on examples.',
                  'image' => asset('assets/mobile-app/banners/course-banner-2.png'),
                  'duration' => '4 weeks',
                  'level' => 'Beginner',
                  'type'  => 'course',

                  'type'  => 'course',
                  'join_link' => 'https://meet.google.com/abc-defg-hij',
                ],
              ],
            ],
            [
              'status' => 'Completed',
              'items' => [
                [
                  'id' => 30,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',
                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 31,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',

                  'type'  => 'webinar',
                  'join_link' => null,
                ],
                [
                  'id' => 32,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',

                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 33,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',

                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 34,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',

                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 35,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',

                  'type'  => 'course',
                  'join_link' => null,
                ],
                [
                  'id' => 36,
                  'title' => 'AWS Cloud Fundamentals',
                  'description' => 'Understand cloud basics and deployment.',
                  'image' => asset('assets/mobile-app/banners/course-banner-3.png'),
                  'duration' => '3 weeks',
                  'level' => 'Advanced',

                  'type'  => 'course',
                  'join_link' => null,
                ],
              ],
            ],
          ],
        ],
        // [
        //   'category' => 'Webinars',
        //   'sections' => [
        //     [
        //       'status' => 'Ongoing',
        //       'items' => [
        //         [
        //           'id' => 4,
        //           'title' => 'AI in Education Webinar',
        //           'description' => 'Explore how AI impacts modern teaching.',
        //           'image' => asset('assets/mobile-app/banners/webinar-banner-1.png'),
        //           'duration' => '1 day',
        //           'level' => 'All',
        //           'join_link' => 'https://zoom.us/j/123456789',
        //         ],
        //       ],
        //     ],
        //   ],
        // ],
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
    Log::info($request->all());
    $id = $request->course_id;

    $course = Course::where('id', $id)->first();
    $teacher = $course?->teachers->first();
    // Dummy class data
    $classDetail = [
      'id' => $id,
      'title' => $course->title,
      'description' => $course->description ?? '',
      // 'teacher_name' => $course->teachers->pluck('name'),

      'teacher_name' => $teacher ? $teacher->name : '',
      'category' => '',
      'price' => $course->net_price,
      'duration' => $course->duration . ' ' . $course->duration_type,
      'thumbnail' => $course->main_image_url,
      'main_image' => $course->main_image_url,
    ];


    // Dummy class materials
    // $materials = [
    //   ['id' => 1, 'title' => 'Introduction to Flutter', 'file_url' => asset('materials/intro.pdf')],
    //   ['id' => 2, 'title' => 'Widgets Deep Dive', 'file_url' => asset('materials/widgets.pdf')],
    // ];

    $materials = MaterialResource::collection($course->materials ?? []);

    // Dummy related classes
    // $classList = [
    //   [
    //     'id' => '1',
    //     'title' => 'Welcome & Setup',
    //     'status' => 'completed',
    //     'teacher' => 'Mark Allen',
    //     'source'    => 'youtube',
    //     'date_time' => '2025-10-01T10:00:00Z',
    //     'recorded_video' => 'https://youtu.be/iLnmTe5Q2Qw',
    //     'join_link' => '',
    //   ],
    //   [
    //     'id' => '1',
    //     'title' => 'Welcome & Setup',
    //     'status' => 'ongoing',
    //     'teacher' => 'Mark Allen',
    //     // 'source'    => 'gmeet',
    //     'source'    => 'youtube',
    //     'date_time' => '2025-10-01T10:00:00Z',
    //     'recorded_video' => '',
    //     // 'join_link' => 'https://meet.google.com/ufr-stwo-jjc',
    //     'join_link' => 'https://www.youtube.com/watch?v=No0B2G5BHjM',
    //   ],
    //   [
    //     'id' => '1',
    //     'title' => 'Welcome & Setup',
    //     'status' => 'upcoming',
    //     'teacher' => 'Mark Allen',
    //     'source'    => '',
    //     'date_time' => '2025-10-01T10:00:00Z',
    //     'recorded_video' => '',
    //     'join_link' => '',
    //   ],
    // ];

    $courseClass = ClassLinkResource::collection($course->classes);



    return response()->json([
      'status' => true,
      'message' => 'Class details fetched successfully',
      'data' => [
        'class_detail' => $classDetail,
        'materials' => $materials,
        'classes' => $courseClass,
      ],
    ]);




    // $course = Course::with([
    //     'materials:id,course_id,title,file_url',
    //     'classes:id,course_id,title,status,date_time,join_link,recorded_video'
    // ])->findOrFail($id);

    // return response()->json([
    //     'class_detail' => [
    //         'id' => $course->id,
    //         'title' => $course->title,
    //         'description' => $course->description,
    //         'image' => $course->image_url,
    //     ],
    //     'materials' => $course->materials,
    //     'classes' => $course->classes,
    // ]);
  }



  public function fetchWebinarDetail(Request $request): JsonResponse
  {
    Log::info($request->all());
    $id = $request->webinar_id;

    $course = Webinar::where('id', $id)->first();
    $teacher = $course?->host->first();
    // Dummy class data
    $classDetail = [
      'id' => $id,
      'title' => $course->title,
      'description' => $course->description ?? '',
      // 'teacher_name' => $course->teachers->pluck('name'),

      'teacher_name' => $teacher ? $teacher->name : '',
      'category' => '',
      'price' => $course->net_price,
      'duration' => $course->duration . ' ' . $course->duration_type,
      'thumbnail' => asset('storage/' . $course->main_image),
      'main_image' => asset('storage/' . $course->main_image),
    ];

    $materials = MaterialResource::collection($course->materials ?? []);
    $materials = [];

    $courseList[] = $course;

    $courseClass = WebinarClassLinkResource::collection($courseList);

    return response()->json([
      'status' => true,
      'message' => 'Class details fetched successfully',
      'data' => [
        'class_detail' => $classDetail,
        'materials' => $materials,
        'classes' => $courseClass,
      ],
    ]);
  }
  public function fetchWorkshopDetail(Request $request): JsonResponse
  {

    $id = $request->workshop_id;

    $course = Workshop::where('id', $id)->first();

    $teacher = $course?->host?->first();
    $classDetail = [
      'id' => $id,
      'title' => $course->title,
      'description' => $course->description ?? '',
      // 'teacher_name' => $course->teachers->pluck('name'),
      'teacher_name' => $teacher ? $teacher->name : '',
      'category' => '',
      'price' => $course->net_price,
      'duration' => $course->duration . ' ' . $course->duration_type,
      'thumbnail' => asset('storage/' . $course->main_image),
      'main_image' => asset('storage/' . $course->main_image),
    ];



    $materials = MaterialResource::collection($course->materials ?? []);
    Log::info($course->classes);
    $courseClass = ClassLinkResource::collection($course->classes);

    return response()->json([
      'status' => true,
      'message' => 'Class details fetched successfully',
      'data' => [
        'class_detail' => $classDetail,
        'materials' => $materials,
        'classes' => $courseClass,
      ],
    ]);
  }



  public function performance(Request $request)
  {
    Log::info($request->user());
    // Dummy response (you can replace with DB values later)
    $data = [
      "total_classes" => 0,
      "attended" => 0,
      "missed" => 0,
      "performance_percentage" => 0,
      "month_wise" => [
        ["month" => "Jan", "attended" => 0, "missed" => 0],
        ["month" => "Feb", "attended" => 0, "missed" => 0],
        ["month" => "Mar", "attended" => 0, "missed" => 0],
      ]
    ];

    return response()->json([
      "status" => true,
      "message" => "success",
      "data" => $data
    ], 200);
  }


  public function UpdatePersonal(Request $request)
  {
    DB::beginTransaction();
    $company_id = 1;
    $student = $request->user();
    $student_id = $student->id;
    Log::info($request->all());

    $user = User::where('id', $student_id)->where('company_id', $company_id)->first();
    Log::info($user);

    try {
      if ($user) {
        // 1️⃣ Create or Update User
        User::where('id', $student_id)
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
          'message'           => 'Student updated successfully'
        ], 201);
      } else {
        DB::rollBack();
        return response()->json([
          'status'            => false,
          'message' => 'Student updation failed',
          'error'   => "User not found",
        ], 500);
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'            => false,
        'message' => 'Student updation failed',
        'error'   => $e->getMessage(),
      ], 500);
    }
  }


  public function enrolledCourses(Request $request)
  {
    $user = $request->user();
    $courses = Course::with('institute')
      ->whereHas('registrations', function ($q) use ($user) {
        $q->where('user_id', $user->id);
      })
      ->where('company_id', 1)
      ->where('is_public', 1)
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      // ->map(fn($c) => tap($c)->is_enrolled = false);
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });



    $webinars = Webinar::where('company_id', 1)
      ->whereHas('registrations', function ($q) use ($user) {
        $q->where('user_id', $user->id);
      })
      ->whereIn('status', ['scheduled', 'completed'])
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });


    // ->map(fn($w) => tap($w)->is_enrolled = false);

    $workshops = Workshop::where('company_id', 1)
      ->whereHas('registrations', function ($q) use ($user) {
        $q->where('user_id', $user->id);
      })
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });
    // ->map(fn($w) => tap($w)->is_enrolled = false);


     $democlasses = DemoClass::where('company_id', 1)
      ->whereHas('registrations', function ($q) use ($user) {
        $q->where('user_id', $user->id);
      })
      ->whereIn('status', ['scheduled', 'completed'])
      ->with(['registrations' => function ($q) use ($user) {
        $q->where('user_id', $user->id);
      }])
      ->get()
      ->map(function ($item) use ($user) {
        $item->is_enrolled = $item->registrations->isNotEmpty();
        return $item;
      });

    $data = collect([

      [
        'category' => 'Course',
        'items'    => CourseResource::collection($courses),
      ],
      [
        'category' => 'Workshop',
        'items'    => WorkshopResource::collection($workshops),
      ],
      [
        'category' => 'Webinar',
        'items'    => WebinarResource::collection($webinars),
      ],
      [
        'category' => 'Demo Class',
        'items'    => WebinarResource::collection($democlasses),
      ]


    ])
    // ->filter(fn($g) => $g['items']->isNotEmpty())
      ->values();

      Log::info($data);

    return response()->json([
      'status' => true,
      'message' => 'Courses categorized successfully',
      'data' => $data,
    ]);
  }
}
