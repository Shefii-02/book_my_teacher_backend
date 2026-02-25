<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\CourseClass;
use App\Models\Purchase;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Webinar;
use App\Models\WorkshopClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Analytics extends Controller
{
  // public function index()
  // {
  //   $company_id = auth()->user()->company_id;
  //   $lastWeek = \Carbon\Carbon::now()->subDays(7);

  //   /** TEACHERS */
  //   $data['teachers']['total'] = Teacher::where('company_id', $company_id)->count();
  //   $data['teachers']['last_week'] = Teacher::where('company_id', $company_id)
  //     ->where('created_at', '>=', $lastWeek)
  //     ->count();

  //   /** STUDENTS */
  //   $data['students']['total'] = User::where('company_id', $company_id)->count();
  //   $data['students']['last_week'] = User::where('company_id', $company_id)
  //     ->where('created_at', '>=', $lastWeek)
  //     ->count();

  //   /** CLASSES (Course + Workshop + Webinar) */
  //   $courseTotal = CourseClass::join('courses', 'courses.id', '=', 'course_classes.course_id')
  //     ->where('courses.company_id', $company_id)
  //     ->count();

  //   $workshopTotal = WorkshopClass::join('workshops', 'workshops.id', '=', 'workshop_classes.workshop_id')
  //     ->where('workshops.company_id', $company_id)
  //     ->count();
  //   $webinarTotal = Webinar::where('company_id', $company_id)->count();

  //   $data['classes']['total'] = $courseTotal + $workshopTotal + $webinarTotal;

  //   $lastWeek = Carbon::now()->subDays(7);

  //   $courseLastWeek = CourseClass::join('courses', 'courses.id', '=', 'course_classes.course_id')
  //     ->where('courses.company_id', $company_id)
  //     ->where('course_classes.created_at', '>=', $lastWeek)
  //     ->count();


  //   $workshopLastWeek = WorkshopClass::join('workshops', 'workshops.id', '=', 'workshop_classes.workshop_id')
  //     ->where('workshops.company_id', $company_id)->where('workshop_classes.created_at', '>=', $lastWeek)
  //     ->count();

  //   $webinarLastWeek = Webinar::where('company_id', $company_id)
  //     ->where('created_at', '>=', $lastWeek)
  //     ->count();

  //   $data['classes']['last_week'] = $courseLastWeek + $workshopLastWeek + $webinarLastWeek;

  //   /** REVENUE */
  //   $data['revenue']['total'] = Purchase::where('company_id', $company_id)
  //     ->join('courses', 'courses.id', '=', 'purchases.course_id')
  //     ->where('purchases.status', 'success')
  //     ->sum('grand_total');

  //   $data['revenue']['last_week'] = Purchase::where('company_id', $company_id)
  //     ->join('courses', 'courses.id', '=', 'purchases.course_id')
  //     ->where('purchases.status', 'success')
  //     ->where('purchases.created_at', '>=', $lastWeek)
  //     ->sum('grand_total');

  //   return view('company.dashboard.index', compact('data'));
  // }
  public function index()
  {

    $company_id = auth()->user()->company_id;
    $lastWeek = \Carbon\Carbon::now()->subDays(7);
    /** SUMMARY CARDS */
    $data = [];

    /** TEACHERS */
    $data['teachers']['total'] = Teacher::where('company_id', $company_id)->count();
    $data['teachers']['last_week'] = Teacher::where('company_id', $company_id)
      ->where('created_at', '>=', $lastWeek)
      ->count();


    //   /** STUDENTS */
    $data['students']['total'] = User::where('company_id', $company_id)->count();
    $data['students']['last_week'] = User::where('company_id', $company_id)
      ->where('created_at', '>=', $lastWeek)
      ->count();


    //   /** CLASSES (Course + Workshop + Webinar) */
    $courseTotal = CourseClass::join('courses', 'courses.id', '=', 'course_classes.course_id')
      ->where('courses.company_id', $company_id)
      ->count();

    $workshopTotal = WorkshopClass::join('workshops', 'workshops.id', '=', 'workshop_classes.workshop_id')
      ->where('workshops.company_id', $company_id)
      ->count();
    $webinarTotal = Webinar::where('company_id', $company_id)->count();

    $data['classes']['total'] = $courseTotal + $workshopTotal + $webinarTotal;

    $lastWeek = Carbon::now()->subDays(7);

    $courseLastWeek = CourseClass::join('courses', 'courses.id', '=', 'course_classes.course_id')
      ->where('courses.company_id', $company_id)
      ->where('course_classes.created_at', '>=', $lastWeek)
      ->count();


    $workshopLastWeek = WorkshopClass::join('workshops', 'workshops.id', '=', 'workshop_classes.workshop_id')
      ->where('workshops.company_id', $company_id)->where('workshop_classes.created_at', '>=', $lastWeek)
      ->count();

    $webinarLastWeek = Webinar::where('company_id', $company_id)
      ->where('created_at', '>=', $lastWeek)
      ->count();

    $data['classes']['last_week'] = $courseLastWeek + $workshopLastWeek + $webinarLastWeek;


    //   /** REVENUE */
    $data['revenue']['total'] = Purchase::where('company_id', $company_id)
      ->join('courses', 'courses.id', '=', 'purchases.course_id')
      ->where('purchases.status', 'paid')
      ->sum('grand_total');

    $data['revenue']['last_week'] = Purchase::where('company_id', $company_id)
      ->join('courses', 'courses.id', '=', 'purchases.course_id')
      ->where('purchases.status', 'paid')
      ->where('purchases.created_at', '>=', $lastWeek)
      ->sum('grand_total');

    /** LINE CHART – LAST 5 WEEKS */
    $weeks = collect(range(0, 4))->map(fn($i) => now()->subWeeks(4 - $i)->startOfWeek());

    $labels = [];
    $students = [];
    $teachers = [];
    $revenue = [];

    foreach ($weeks as $weekStart) {
      $weekEnd = $weekStart->copy()->endOfWeek();

      $labels[] = $weekStart->format('d M');

      $students[] = User::whereBetween('created_at', [$weekStart, $weekEnd])
        ->where('acc_type', 'student')
        ->where('company_id', $company_id)
        ->count();

      $teachers[] = User::whereBetween('created_at', [$weekStart, $weekEnd])
        ->where('acc_type', 'teacher')
        ->where('company_id', $company_id)
        ->count();

      $revenue[] = Purchase::whereBetween('created_at', [$weekStart, $weekEnd])
        // ->where('company_id', $company_id)
        ->where('status', 'paid')
        ->sum('grand_total');
    }

    $data['chart'] = compact('labels', 'students', 'teachers', 'revenue');



    $data['top_teachers'] = User::whereHas('teachers')->select(
      'users.id',
      'users.name',
      DB::raw('COUNT(DISTINCT teacher_courses.id) as courses'),
      DB::raw('COUNT(course_classes.id) as classes'),
      DB::raw('SUM(purchases.grand_total) as revenue')
    )
      ->leftJoin('teacher_courses', 'teacher_courses.teacher_id', '=', 'users.id')
      ->leftJoin('purchases', 'purchases.course_id', '=', 'teacher_courses.course_id')
      ->leftJoin('course_classes', 'course_classes.course_id', '=', 'teacher_courses.course_id')
      ->where('users.company_id', $company_id)
      ->where('acc_type','teacher')
      // ->where('purchases.status', 'paid')
      ->groupBy('users.id', 'users.name')
      ->orderByDesc('revenue')
      ->limit(5)
      ->get();

    // $data['chart'] = [
    //   'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
    //   'students' => [120, 180, 260, 310, 400],
    //   'teachers' => [12, 18, 25, 22, 30],
    //   'revenue' => [120000, 180000, 260000, 300000, 420000],
    // ];

    /** TOP TEACHERS */
    // $data['top_teachers'] = [
    //   [
    //     'name' => 'Arjun Menon',
    //     'courses' => 12,
    //     'classes' => 140,
    //     'watch_time' => '1,240 hrs',
    //     'revenue' => 520000,
    //   ],
    //   [
    //     'name' => 'Sneha Nair',
    //     'courses' => 9,
    //     'classes' => 98,
    //     'watch_time' => '980 hrs',
    //     'revenue' => 410000,
    //   ],
    //   [
    //     'name' => 'Rahul Das',
    //     'courses' => 7,
    //     'classes' => 86,
    //     'watch_time' => '760 hrs',
    //     'revenue' => 295000,
    //   ],
    // ];

    // /** DEVICES */
    $data['devices'] = [
      ['name' => 'Android', 'users' => 0, 'percent' => 0],
      ['name' => 'iOS', 'users' => 0, 'percent' => 0],
      ['name' => 'Web', 'users' => 0, 'percent' => 0],
    ];

    // /** TRAFFIC SOURCES */
    $data['sources'] = [
      ['name' => 'Google Search', 'visits' => 0],
      ['name' => 'Facebook Ads', 'visits' => 0],
      ['name' => 'Instagram', 'visits' => 0],
      ['name' => 'Direct', 'visits' => 0],
    ];

    // /** TOP CITIES */
    $data['cities'] = [
      ['name' => 'Bangalore', 'users' => 0],
      ['name' => 'Kochi', 'users' => 0],
      ['name' => 'Chennai', 'users' => 0],
      ['name' => 'Hyderabad', 'users' => 0],
    ];


    $analytics = [
      'web' => [
        'visitors_count' => 0,
        'buy_now_click_count' => 0,
        'new_students_count' => 0,
        'new_teachers_count' => 0,
        'remove_accounts_count' => 0,
        'total_purchases_count' => 0,
        'total_revenue' => 0,
      ],
      'android' => [
        'visitors_count' => 0,
        'buy_now_click_count' => 0,
        'new_students_count' => 0,
        'new_teachers_count' => 0,
        'remove_accounts_count' => 0,
        'total_purchases_count' => 0,
        'total_revenue' => 0,
      ],
      'ios' => [
        'visitors_count' => 0,
        'buy_now_click_count' => 0,
        'new_students_count' => 0,
        'new_teachers_count' => 0,
        'remove_accounts_count' => 0,
        'total_purchases_count' => 0,
        'total_revenue' => 0,
      ],
    ];



    // $source_analytics = [
    //   'web' => [
    //     'visitors_count' => 850,
    //     'buy_now_click_count' => 120,
    //     'new_students_count' => 60,
    //     'new_teachers_count' => 10,
    //     'remove_accounts_count' => 4,
    //     'total_purchases_count' => 45,
    //     'total_revenue' => 28000,
    //   ],
    //   'android' => [
    //     'visitors_count' => 600,
    //     'buy_now_click_count' => 95,
    //     'new_students_count' => 45,
    //     'new_teachers_count' => 8,
    //     'remove_accounts_count' => 2,
    //     'total_purchases_count' => 35,
    //     'total_revenue' => 22000,
    //   ],
    //   'ios' => [
    //     'visitors_count' => 420,
    //     'buy_now_click_count' => 70,
    //     'new_students_count' => 30,
    //     'new_teachers_count' => 5,
    //     'remove_accounts_count' => 1,
    //     'total_purchases_count' => 22,
    //     'total_revenue' => 16000,
    //   ],
    // ];

    return view('company.dashboard.index', compact('data', 'analytics'));
  }
}
