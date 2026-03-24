<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\SubjectReview;
use App\Models\Teacher;
use App\Models\User;
use App\Models\AppReview;
use App\Models\VideoTestimonial;


class HomeController extends Controller
{

  public function index()
  {
    // Summary stats
    // $total_students = User::where('acc_type','student')->count();
    // $expert_teachers = Teacher::count();
    // $avg_rating = AppReview::avg('rating');
    // $available_countries = 3;

    // // App reviews
    // $app_reviews = AppReview::latest()->take(10)->get();

    // // Subjects with teachers
    // $subjects = Subject::with(['teachers'])->get();

    // // Countries with teachers
    // $countries = collect();

    // Video testimonials
    // $video_testimonials = VideoTestimonial::where('type', 'video')->get();

    // // Top teachers
    // $top_teachers = Teacher::withAvg('reviews', 'rating')
    //   ->orderByDesc('reviews_avg_rating')
    //   ->take(10)
    //   ->get();

    // // Teacher class reviews
    // $teacher_reviews = SubjectReview::with(['teacher', 'student'])->latest()->get();

    // // Grades with boards and subjects
    // $grades = Grade::with(['boards.subjects'])->get();

    // Boards only
    // $boards = Board::all();

    // // Subjects only
    // $all_subjects = Subject::all();

    $company_id = 1;

    $data = [
      'students_count' => User::where('acc_type', 'student')->where('company_id', $company_id)->count(),
      'teachers_count' => Teacher::where('company_id', $company_id)->count(),
      'avg_rating'    => 4.9,
      'country_count'     => 7,
      'popular_search' => ['Mathematics', 'Physics', 'Chemistry', 'English', 'NEET', 'JEE', 'Home Tuition'],
      'app_reviews'   => [
        [
          'user_name' => 'Sam',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('sam'),
          'rating' => 5,
          'message' => "The AI course was fantastic! The live classes and hands-on projects really helped.",
        ],
        [
          'user_name' => 'Jon',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Jon'),
          'rating' => 5,
          'message' => "The AI course was fantastic! The live classes and hands-on projects really helped.",
        ],
        [
          'user_name' => 'Luka',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Luka'),
          'rating' => 5,
          'message' => "The AI course was fantastic! The live classes and hands-on projects really helped.",
        ]
      ],


      'subjects'      => [
        ['name' => 'Mathematics', 'image' => '',],
        ['name' => 'Physics', 'image' => '',],
        ['name' => 'Chemistry', 'image' => '',],
        ['name' => 'Biology', 'image' => '',],
        ['name' => 'English', 'image' => '',],
        ['name' => 'Science', 'image' => '',],
        ['name' => 'Social Studies', 'image' => '',],
        ['name' => 'Computer Sci.', 'image' => '',],
        ['name' => 'Hindi', 'image' => '',],
        ['name' => 'Malayalam', 'image' => '',],
        ['name' => 'History', 'image' => '',],
        ['name' => 'Economics', 'image' => '',],
        ['name' => 'JEE Prep', 'image' => '',],
        ['name' => 'NEET Prep', 'image' => '',],
        ['name' => 'Accountancy', 'image' => '',],
        ['name' => 'Geography', 'image' => '',],
      ],

      'countries'     => [
        ['name' => 'India', 'flag' => '🇮🇳', 'teachers_count' => 200],
        ['name' => 'UAE / Dubai', 'flag' => '🇦🇪', 'teachers_count' => 80],
        ['name' => 'Qatar', 'flag' => '🇶🇦', 'teachers_count' => 45],
        ['name' => 'Oman', 'flag' => '🇴🇲', 'teachers_count' => 38],
        ['name' => 'Saudi Arabia', 'flag' => '🇸🇦', 'teachers_count' => 55],
        ['name' => 'Bahrain', 'flag' => '🇧🇭', 'teachers_count' => 28],
        ['name' => 'Kuwait', 'flag' => '🇰🇼', 'teachers_count' => 28],
      ],
      'video_testimonial' => [
        [
          'video_url' => 'https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1',
          'subject' => '10th Success',
          'message' => "Cleared NEET on first attempt with home tuition!",
          'name_place' => 'Anjali Nair · Tamil Nadu',
        ],
        [
          'video_url' => 'https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1',
          'subject' => '12th Success',
          'message' => "Cleared NEET on first attempt with home tuition!",
          'name_place' => 'Anjali Nair · Tamil Nadu',
        ],
        [
          'video_url' => 'https://www.youtube.com/embed/vML991fMZ9o?rel=0&modestbranding=1',
          'subject' => 'UG Success',
          'message' => "Cleared NEET on first attempt with home tuition!",
          'name_place' => 'Anjali Nair · Tamil Nadu',
        ],
      ],
      'expert_teachers' => [
        [
          'name' => 'Rahul Menon',
          'avatar_url' => '',
          'expert' => 'Mathematics & Physics Expert',
          'experience' => '8 yrs',
          'students' => '320 students',
          'mode' => 'Home & Online',
          'subjects' => ['Maths', 'Physics', 'JEE'],
          'Rating' => '4.9',
          'Reviews' => '128',
        ],
        [
          'name' => 'Rahul Menon',
          'avatar_url' => '',
          'expert' => 'Mathematics & Physics Expert',
          'experience' => '8 yrs',
          'students' => '320 students',
          'mode' => 'Home & Online',
          'subjects' => ['Maths', 'Physics', 'JEE'],
          'Rating' => '4.9',
          'Reviews' => '128',
        ],
        [
          'name' => 'Rahul Menon',
          'avatar_url' => '',
          'expert' => 'Mathematics & Physics Expert',
          'experience' => '8 yrs',
          'students' => '320 students',
          'mode' => 'Home & Online',
          'subjects' => ['Maths', 'Physics', 'JEE'],
          'Rating' => '4.9',
          'Reviews' => '128',
        ],
      ],
      'parent_say_reviews' => [
        [
          'user_name' => 'Anjali Nair',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Jon'),
          'rating' => 5,
          'message' => "Cleared NEET on my first attempt! The Chemistry sessions were so structured. The home tutor visited every evening.",
          'type' => 'Student',
          'secion' => 'NEET 2024',
          'Tamil Nadu' => '',
        ],
        [
          'user_name' => 'Anjali Nair',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Jon'),
          'rating' => 5,
          'message' => "Cleared NEET on my first attempt! The Chemistry sessions were so structured. The home tutor visited every evening.",
          'type' => 'Student',
          'secion' => 'NEET 2024',
          'Tamil Nadu' => ''
        ],
        [
          'user_name' => 'Anjali Nair',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Jon'),
          'rating' => 5,
          'message' => "Cleared NEET on my first attempt! The Chemistry sessions were so structured. The home tutor visited every evening.",
          'type' => 'Student',
          'secion' => 'NEET 2024',
          'Tamil Nadu' => ''
        ],
        [
          'user_name' => 'Anjali Nair',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Jon'),
          'rating' => 5,
          'message' => "Cleared NEET on my first attempt! The Chemistry sessions were so structured. The home tutor visited every evening.",
          'type' => 'Student',
          'secion' => 'NEET 2024',
          'Tamil Nadu' => ''
        ],
        [
          'user_name' => 'Anjali Nair',
          'avatar' => "https://placehold.co/50x50/png?text=" . Str::ucfirst('Jon'),
          'rating' => 5,
          'message' => "Cleared NEET on my first attempt! The Chemistry sessions were so structured. The home tutor visited every evening.",
          'type' => 'Student',
          'secion' => 'NEET 2024',
          'Tamil Nadu' => ''
        ],
      ],
    ];

    $grades = Grade::where('company_id', $company_id)->get();
    $boards = Board::where('company_id', $company_id)->get();
    $subjects = Subject::where('company_id', $company_id)->get();
// dd($data);
    return view(
      'home.index',
      compact(
        'grades',
        'boards',
        'subjects',
        'data'
      )
    );
  }
}
