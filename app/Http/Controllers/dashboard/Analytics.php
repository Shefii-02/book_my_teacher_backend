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
  public function index()
  {
    $company_id = auth()->user()->company_id;
    $lastWeek = \Carbon\Carbon::now()->subDays(7);

    /** TEACHERS */
    $data['teachers']['total'] = Teacher::where('company_id', $company_id)->count();
    $data['teachers']['last_week'] = Teacher::where('company_id', $company_id)
      ->where('created_at', '>=', $lastWeek)
      ->count();

    /** STUDENTS */
    $data['students']['total'] = User::where('company_id', $company_id)->count();
    $data['students']['last_week'] = User::where('company_id', $company_id)
      ->where('created_at', '>=', $lastWeek)
      ->count();

    /** CLASSES (Course + Workshop + Webinar) */
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

    /** REVENUE */
    $data['revenue']['total'] = Purchase::where('company_id', $company_id)
      ->join('courses', 'courses.id', '=', 'purchases.course_id')
      ->where('purchases.status', 'success')
      ->sum('grand_total');

    $data['revenue']['last_week'] = Purchase::where('company_id', $company_id)
      ->join('courses', 'courses.id', '=', 'purchases.course_id')
      ->where('purchases.status', 'success')
      ->where('purchases.created_at', '>=', $lastWeek)
      ->sum('grand_total');

    return view('company.dashboard.index', compact('data'));
  }
}
