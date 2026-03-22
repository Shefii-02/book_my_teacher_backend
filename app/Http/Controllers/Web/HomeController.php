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
use App\Models\Teacher;
use Google\Service\AndroidPublisher\Review;
use Google\Service\Classroom\Student;
use Google\Service\Dfareporting\Country;

class HomeController extends Controller
{

  public function index()
  {
    // Summary stats
    $total_students = Student::count();
    $expert_teachers = Teacher::where('is_expert', 1)->count();
    $avg_rating = Review::avg('rating');
    $available_countries = Country::count();

    // App reviews
    $app_reviews = Review::latest()->take(10)->get();

    // Subjects with teachers
    $subjects = Subject::with(['teachers'])->get();

    // Countries with teachers
    $countries = Country::with(['teachers'])->get();

    // Video testimonials
    $video_testimonials = Testimonial::where('type', 'video')->get();

    // Top teachers
    $top_teachers = Teacher::withAvg('reviews', 'rating')
      ->orderByDesc('reviews_avg_rating')
      ->take(10)
      ->get();

    // Teacher class reviews
    $teacher_reviews = Review::with(['teacher', 'student'])->latest()->get();

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
