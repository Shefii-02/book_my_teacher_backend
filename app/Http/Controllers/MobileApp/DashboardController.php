<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Purchase;
use App\Models\Teacher;
use App\Models\TopTeacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    $company_id = auth()->user()->company_id;
    // ===============================
    // 🔥 TOP STATS
    // ===============================
    $students = User::where('company_id', $company_id)->where('acc_type', 'student')->count();
    $teachers = Teacher::where('company_id', $company_id)->count();
    $courses  = Course::where('company_id', $company_id)->count();

    $liveToday = CourseClass::whereDate('scheduled_at', today())
      // ->where('status', 'live')
      ->count();

    // ===============================
    // 📊 WATCH vs SPEND CHART
    // ===============================
    $watchSpend = DB::table('spend_class_time_analytics')
      ->select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(spend_duration) as watch'),
        DB::raw('SUM(watch_duration) as spend')
      )
      ->groupBy('date')
      ->orderBy('date')
      ->limit(7)
      ->get();

    $watchSeries = $watchSpend->pluck('watch');
    $spendSeries = $watchSpend->pluck('spend');

    // ===============================
    // 💰 MONTHLY REVENUE
    // ===============================
    $revenue = Purchase::select(
      DB::raw('MONTH(created_at) as month'),
      DB::raw('SUM(grand_total) as total')
    )
      ->whereYear('created_at', now()->year)
      ->groupBy('month')
      ->orderBy('month')
      ->pluck('total');

    // ===============================
    // 📦 EXTRA SECTIONS
    // ===============================
    $pendingTeachers = User::where('acc_type', 'teacher')->where('status', '!=', 'approved')->count();
    $topTeachers     = 	User::whereHas('top_teachers')->where('acc_type', 'teacher')->count();

    $grades  = DB::table('grades')->count();
    $boards  = DB::table('boards')->count();
    $subjects = DB::table('subjects')->count();

    $wallet = DB::table('wallets')->sum('rupee_balance');
    $referrals = DB::table('app_referrals')->count();
    $transfers = DB::table('transfer_requests')->count();

    $courseReviews = DB::table('subject_reviews')->count();
    $teacherReviews = DB::table('subject_reviews')->count();
    $pendingReviews = DB::table('subject_reviews')->count();

    return view('company.mobile-app.dashboard.index', compact(
      'students',
      'teachers',
      'courses',
      'liveToday',
      'watchSeries',
      'spendSeries',
      'revenue',
      'pendingTeachers',
      'topTeachers',
      'grades',
      'boards',
      'subjects',
      'wallet',
      'referrals',
      'transfers',
      'courseReviews',
      'teacherReviews',
      'pendingReviews'
    ));
  }
}
