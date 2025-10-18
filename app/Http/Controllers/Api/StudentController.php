<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use App\Models\Teacher;
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

    $studentId = $request->input('student_id'); // frontend should send teacher_id

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




  public function topBanners(): JsonResponse
  {
    $banners = collect(range(1, 15))->map(function ($i) {
      return [
        'id' => $i,
        'title' => "Top Banner $i",
        'main_image' => "https://cdn.app/banner_$i.jpg",
        'thumb' => "https://cdn.app/banner_{$i}_thumb.jpg",
        'description' => "This is banner $i description.",
        'priority_order' => $i,
        'banner_type' => $i % 2 ? 'image' : 'video',
        'cta_label' => 'Join Now',
        'cta_action' => '/register',
        'is_booked' => $i % 3 === 0,
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
  public function gradesSubjects(): JsonResponse {
    $grades = collect(range(1,5))->map(function($i){
            return [
                'title' => "Grade $i",
                'value' => "grade_$i",
                'icon' => "https://cdn.app/icons/grade_$i.png",
                'color_code' => '#FFD700',
                'difficulty_level' => 'medium',
                'syllabus_reference' => "CBSE Grade $i Syllabus",
                'position' => $i,
                'subjects' => collect(range(1,3))->map(function($j){
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
        return response()->json(['status'=>true,'data'=>$grades]);
  }
  public function boardSyllabus(): JsonResponse {
    $boards = [
            [
                'name' => 'CBSE',
                'grades_covered' => ['Grade 1–12'],
                'subject_covered' => ['Maths','Science','English'],
                'logo' => 'https://cdn.app/cbse_logo.png',
                'curriculum_type' => 'National',
                'language_options' => ['English','Hindi']
            ],
            [
                'name' => 'ICSE',
                'grades_covered' => ['Grade 1–12'],
                'subject_covered' => ['Maths','Physics','Chemistry'],
                'logo' => 'https://cdn.app/icse_logo.png',
                'curriculum_type' => 'Private',
                'language_options' => ['English']
            ]
        ];
        return response()->json(['status'=>true,'data'=>$boards]);
  }
  public function myWallet(): JsonResponse {
    return response()->json([
            'green_coins' => 120,
            'rupees' => 450,
            'coin_redeem_min' => 50,
            'rupee_redeem_min' => 100,
            'wallet_type' => 'premium',
            'auto_redeem_status' => true,
            'rewards_level' => 'Gold',
            'transactions' => [
                [
                    'transaction_id' => 'TXN2025-001',
                    'category' => 'redeem',
                    'cash' => 100,
                    'date' => now()->subDays(1)->toDateString()
                ]
            ],
            'green_coin_history' => [
                ['category'=>'referral','points'=>10,'date'=>now()->subDays(3)->toDateString()]
            ]
        ]);
  }
  public function Referral(): JsonResponse {
    return response()->json([
            'referral_link' => 'https://bookmyteacher.com/ref/ABC123',
            'qr_code_url' => 'https://cdn.app/qr/ABC123.png',
            'bonus_threshold' => 5,
            'expiry_date' => now()->addMonths(2)->toDateString(),
            'my_referral_list' => [
                ['name'=>'Ankit','joined_at'=>'2025-09-12'],
                ['name'=>'Riya','joined_at'=>'2025-09-18']
            ],
            'referral_terms_points' => [
                ['category'=>'signup','points'=>10],
                ['category'=>'review','points'=>5]
            ],
            'reward_per_referral' => 20
        ]);
  }
  public function provideSubjects(): JsonResponse {
     $subjects = collect(range(1,15))->map(function($i){
            return [
                'title' => "Subject $i",
                'value' => "subject_$i",
                'description' => "Description for subject $i",
                'booked_status' => $i % 2 === 0,
                'date' => now()->toDateString(),
                'icon' => "https://cdn.app/icons/sub_$i.png"
            ];
        });
        return response()->json(['status'=>true,'data'=>$subjects]);
  }
  public function provideCourses(): JsonResponse {
    $courses = collect(range(1,15))->map(function($i){
            return [
                'title' => "Course $i",
                'value' => "course_$i",
                'description' => "Learn subject in depth $i",
                'booked_status' => $i % 3 === 0,
                'date' => now()->toDateString(),
                'total_enrollments' => rand(50,300),
                'teacher_details' => [
                    ['name'=>'Teacher A','rating'=>4.8,'experience'=>8]
                ]
            ];
        });
        return response()->json(['status'=>true,'data'=>$courses]);
  }
}
