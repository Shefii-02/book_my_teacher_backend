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
    $total_students = User::where('acc_type','student')->count();
    $expert_teachers = Teacher::count();
    $avg_rating = AppReview::avg('rating');
    $available_countries = 3;

    // App reviews
    $app_reviews = AppReview::latest()->take(10)->get();

    // Subjects with teachers
    $subjects = Subject::with(['teachers'])->get();

    // Countries with teachers
    $countries = collect();

    // Video testimonials
    $video_testimonials = VideoTestimonial::where('type', 'video')->get();

    // Top teachers
    $top_teachers = Teacher::withAvg('reviews', 'rating')
      ->orderByDesc('reviews_avg_rating')
      ->take(10)
      ->get();

    // Teacher class reviews
    $teacher_reviews = SubjectReview::with(['teacher', 'student'])->latest()->get();

    // Grades with boards and subjects
    $grades = Grade::with(['boards.subjects'])->get();

    // Boards only
    $boards = Board::all();

    // Subjects only
    $all_subjects = Subject::all();

    return view('home.index', compact(
      'total_students',
      'expert_teachers',
      'avg_rating',
      'available_countries',
      'app_reviews',
      'subjects',
      'countries',
      'video_testimonials',
      'top_teachers',
      'teacher_reviews',
      'grades',
      'boards',
      'all_subjects'
    ));
  }
}
