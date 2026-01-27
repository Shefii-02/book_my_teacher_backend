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
    $data = [];

    /** SUMMARY CARDS */
    $data['students'] = [
      'total' => 12450,
      'last_week' => 320,
    ];

    $data['teachers'] = [
      'total' => 860,
      'last_week' => 24,
    ];

    $data['classes'] = [
      'total' => 1340,
      'last_week' => 58,
    ];

    $data['revenue'] = [
      'total' => 4852000,   // ₹48,52,000
      'last_week' => 342000 // ₹3,42,000
    ];

    /** LINE CHART – LAST 5 WEEKS */
    $data['chart'] = [
      'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'],
      'students' => [120, 180, 260, 310, 400],
      'teachers' => [12, 18, 25, 22, 30],
      'revenue' => [120000, 180000, 260000, 300000, 420000],
    ];

    /** TOP TEACHERS */
    $data['top_teachers'] = [
      [
        'name' => 'Arjun Menon',
        'courses' => 12,
        'classes' => 140,
        'watch_time' => '1,240 hrs',
        'revenue' => 520000,
      ],
      [
        'name' => 'Sneha Nair',
        'courses' => 9,
        'classes' => 98,
        'watch_time' => '980 hrs',
        'revenue' => 410000,
      ],
      [
        'name' => 'Rahul Das',
        'courses' => 7,
        'classes' => 86,
        'watch_time' => '760 hrs',
        'revenue' => 295000,
      ],
    ];

    /** DEVICES */
    $data['devices'] = [
      ['name' => 'Android', 'users' => 7200, 'percent' => 58],
      ['name' => 'iOS', 'users' => 3400, 'percent' => 27],
      ['name' => 'Web', 'users' => 1850, 'percent' => 15],
    ];

    /** TRAFFIC SOURCES */
    $data['sources'] = [
      ['name' => 'Google Search', 'visits' => 6200],
      ['name' => 'Facebook Ads', 'visits' => 2800],
      ['name' => 'Instagram', 'visits' => 2100],
      ['name' => 'Direct', 'visits' => 1400],
    ];

    /** TOP CITIES */
    $data['cities'] = [
      ['name' => 'Bangalore', 'users' => 2100],
      ['name' => 'Kochi', 'users' => 1800],
      ['name' => 'Chennai', 'users' => 1600],
      ['name' => 'Hyderabad', 'users' => 1400],
    ];


    $analytics = [
      'web' => [
        'visitors_count' => 850,
        'buy_now_click_count' => 120,
        'new_students_count' => 60,
        'new_teachers_count' => 10,
        'remove_accounts_count' => 4,
        'total_purchases_count' => 45,
        'total_revenue' => 28000,
      ],
      'android' => [
        'visitors_count' => 600,
        'buy_now_click_count' => 95,
        'new_students_count' => 45,
        'new_teachers_count' => 8,
        'remove_accounts_count' => 2,
        'total_purchases_count' => 35,
        'total_revenue' => 22000,
      ],
      'ios' => [
        'visitors_count' => 420,
        'buy_now_click_count' => 70,
        'new_students_count' => 30,
        'new_teachers_count' => 5,
        'remove_accounts_count' => 1,
        'total_purchases_count' => 22,
        'total_revenue' => 16000,
      ],
    ];



    $source_analytics = [
      'web' => [
        'visitors_count' => 850,
        'buy_now_click_count' => 120,
        'new_students_count' => 60,
        'new_teachers_count' => 10,
        'remove_accounts_count' => 4,
        'total_purchases_count' => 45,
        'total_revenue' => 28000,
      ],
      'android' => [
        'visitors_count' => 600,
        'buy_now_click_count' => 95,
        'new_students_count' => 45,
        'new_teachers_count' => 8,
        'remove_accounts_count' => 2,
        'total_purchases_count' => 35,
        'total_revenue' => 22000,
      ],
      'ios' => [
        'visitors_count' => 420,
        'buy_now_click_count' => 70,
        'new_students_count' => 30,
        'new_teachers_count' => 5,
        'remove_accounts_count' => 1,
        'total_purchases_count' => 22,
        'total_revenue' => 16000,
      ],
    ];
    return view('company.dashboard.index', compact('data', 'analytics', 'source_analytics'));
  }
}
