<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\AppReferral;
use App\Models\CourseClass;
use App\Models\DemoClass;
use App\Models\SpendTimeClassAnalytics;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\Webinar;
use App\Models\WorkshopClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsSpendController extends Controller
{

  public function index(Request $request)
  {
    $company_id = auth()->user()->company_id;
    $status = $request->status ?? 'pending';

    $classes = collect();

    /*
    |--------------------------------------------------------------------------
    | COURSE CLASSES
    |--------------------------------------------------------------------------
    */
    $courseClasses = CourseClass::with(['course_data', 'durationAnalytics'])
      ->whereHas('course_data', function ($q) use ($company_id) {
        $q->where('company_id', $company_id);
      })->get();

    foreach ($courseClasses as $item) {
      $analytics = $item->durationAnalytics;
      $statusValue = $analytics?->status ?? 'pending';

      $classes->push([
        'id' => $item->id,
        'type' => 'course',
        'title' => $item->title,
        'parent_title' => $item->course_data->title ?? '-',
        'image' => $item->course_data->mian_image_url ?? null,
        'source' => $item->class_mode,
        'spend_duration' => $analytics?->spend_duration ?? 0,
        'watch_duration' => $analytics?->watch_duration ?? 0,
        'teacher_name' => $item->teacher->name ?? '-',
        'teacher_avatar' => $item->teacher->avatar ?? null,
        'class_date' => $item->scheduled_at,
        'started_at' => $item->start_time,
        'ended_at' => $item->end_time,
        'class_mode' => $item->type,
        'class_link' => $item->meeting_link,
        'recorded_link' => $item->recording_url,
        'status' => $statusValue,
      ]);
    }

    /*
    |--------------------------------------------------------------------------
    | WORKSHOP CLASSES
    |--------------------------------------------------------------------------
    */
    $workshopClasses = WorkshopClass::with(['workshop', 'durationAnalytics'])
      ->whereHas('workshop', function ($q) use ($company_id) {
        $q->where('company_id', $company_id);
      })->get();

    foreach ($workshopClasses as $item) {
      $analytics = $item->durationAnalytics;
      $statusValue = $analytics?->status ?? 'pending';

      $classes->push([
        'id' => $item->id,
        'type' => 'workshop',
        'title' => $item->title,
        'parent_title' => $item->workshop->title ?? '-',
        'image' => $item->workshop->mian_image_url ?? null,
        'source' => $item->class_mode,
        'spend_duration' => $analytics?->spend_duration ?? 0,
        'watch_duration' => $analytics?->watch_duration ?? 0,
        'teacher_name' => $item->teacher->name ?? '-',
        'teacher_avatar' => $item->teacher->avatar ?? null,
        'class_date' => $item->scheduled_at,
        'started_at' => $item->start_time,
        'ended_at' => $item->end_time,
        'class_mode' => $item->type,
        'class_link' => $item->meeting_link,
        'recorded_link' => $item->recording_url,
        'status' => $statusValue,
      ]);
    }

    /*
    |--------------------------------------------------------------------------
    | WEBINARS
    |--------------------------------------------------------------------------
    */
    $webinarClasses = Webinar::with([ 'durationAnalytics'])
      ->where('company_id', $company_id)
      ->get();

    foreach ($webinarClasses as $item) {
      $analytics = $item->durationAnalytics;
      $statusValue = $analytics?->status ?? 'pending';

      $classes->push([
        'id' => $item->id,
        'type' => 'webinar',
        'title' => $item->title,
        'parent_title' => $item->title ?? '-',
        'image' => $item->main_image_url ?? null,
        'source' => $item->class_mode,
        'spend_duration' => $analytics?->spend_duration ?? 0,
        'watch_duration' => $analytics?->watch_duration ?? 0,
        'teacher_name' => $item->teacher->name ?? '-',
        'teacher_avatar' => $item->teacher->avatar ?? null,
        'class_date' => $item->scheduled_at,
        'started_at' => $item->start_time,
        'ended_at' => $item->end_time,
        'class_mode' => $item->type,
        'class_link' => $item->meeting_link,
        'recorded_link' => $item->recording_url,
        'status' => $statusValue,
      ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DEMO CLASSES
    |--------------------------------------------------------------------------
    */
    $demoClasses = DemoClass::with([ 'durationAnalytics'])
      ->where('company_id', $company_id)
      ->get();

    foreach ($demoClasses as $item) {
      $analytics = $item->durationAnalytics;
      $statusValue = $analytics?->status ?? 'pending';

      $classes->push([
        'id' => $item->id,
        'type' => 'demo',
        'title' => $item->title,
        'parent_title' => $item->title ?? '-',
        'image' => $item->main_image_url ?? null,
        'source' => $item->source,
        'spend_duration' => $analytics?->spend_duration ?? 0,
        'watch_duration' => $analytics?->watch_duration ?? 0,
        'teacher_name' => $item->teacher->name ?? '-',
        'teacher_avatar' => $item->teacher->avatar ?? null,
        'class_date' => $item->scheduled_at,
        'started_at' => $item->start_time,
        'ended_at' => $item->end_time,
        'class_mode' => $item->class_mode,
        'class_link' => $item->meeting_link,
        'recorded_link' => $item->recording_url,
        'status' => $statusValue,
      ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SORT + FILTER
    |--------------------------------------------------------------------------
    */

    // Sort latest first
    $classes = $classes->sortByDesc('class_date');

    // Filter by status
    if ($status) {
      $classes = $classes->filter(fn($c) => $c['status'] === $status);
    }

    return view('company.mobile-app.statistics.spend-index', compact('classes', 'status'));
  }

  // public function index()
  // {
  //   $company_id       = auth()->user()->company_id;
  //   $courseClasses    = CourseClass::whereHas('course_data', function ($q) use ($company_id) {
  //     $q->where('company_id', $company_id);
  //   })->get();
  //   $workshopClasses  = WorkshopClass::whereHas('workshop', function ($q) use ($company_id) {
  //     $q->where('company_id', $company_id);
  //   })->get();
  //   $webinarClasses   = Webinar::where('company_id', $company_id)->get();
  //   $demoClasses      = DemoClass::where('company_id', $company_id)->get();
  //   $status = $request->status ?? 'pending';
  //   $classes = collect();

  //   // Course
  //   foreach ($courseClasses ?? [] as $item) {
  //     $classes->push([
  //       'id' => $item->id,
  //       'type' => 'course',
  //       'title' => $item->title,
  //       'parent_title' => $item->course_data->title ?? '-',
  //       'image' => $item->course_data->mian_image_url,
  //       'source' => $item->class_mode,
  //       'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
  //       'watch_duration' => $item->durationAnalytics?->watch_duration ?? 0,
  //       'teacher_name' => $item->teacher->name ?? '-',
  //       'teacher_avatar' => $item->teacher->avatar ?? null,
  //       'class_date' => $item->scheduled_at,
  //       'started_at' => $item->start_time,
  //       'ended_at' => $item->end_time,
  //       'class_mode' => $item->type,
  //       'class_link' => $item->meeting_link,
  //       'recorded_link' => $item->recording_url,
  //     ]);
  //   }

  //   // Workshop
  //   foreach ($workshopClasses ?? [] as $item) {
  //     $classes->push([
  //       'id' => $item->id,
  //       'type' => 'workshop',
  //       'title' => $item->title,
  //       'parent_title' => $item->workshop->title ?? '-',
  //       'image' => $item->workshop->mian_image_url,
  //       'source' => $item->class_mode,
  //       'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
  //       'watch_duration' => $item->durationAnalytics?->watch_duration ?? 0,
  //       'teacher_name' => $item->teacher->name ?? '-',
  //       'teacher_avatar' => $item->teacher->avatar ?? null,
  //       'class_date' => $item->scheduled_at,
  //       'started_at' => $item->start_time,
  //       'ended_at' => $item->end_time,
  //       'class_mode' => $item->type,
  //       'class_link' => $item->meeting_link,
  //       'recorded_link' => $item->recording_url,
  //     ]);
  //   }

  //   // Webinar
  //   foreach ($webinarClasses ?? [] as $item) {
  //     $classes->push([
  //       'id' => $item->id,
  //       'type' => 'webinar',
  //       'title' => $item->title,
  //       'parent_title' => $item->title ?? '-',
  //       'image' => $item->main_image_url,
  //       'source' => $item->class_mode,
  //       'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
  //       'watch_duration' => $item->durationAnalytics?->watch_duration ?? 0,
  //       'teacher_name' => $item->teacher->name ?? '-',
  //       'teacher_avatar' => $item->teacher->avatar ?? null,
  //       'class_date' => $item->scheduled_at,
  //       'started_at' => $item->start_time,
  //       'ended_at' => $item->end_time,
  //       'class_mode' => $item->type,
  //       'class_link' => $item->meeting_link,
  //       'recorded_link' => $item->recording_url,
  //     ]);
  //   }

  //   // Demo
  //   foreach ($demoClasses ?? [] as $item) {
  //     $classes->push([
  //       'id' => $item->id,
  //       'type' => 'demo',
  //       'title' => $item->title,
  //       'parent_title' => $item->title ?? '-',
  //       'image' => $item->main_image_url,
  //       'source' => $item->source,
  //       'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
  //       'watch_duration' => $item->durationAnalytics?->watch_duration ?? 0,
  //       'teacher_name' => $item->teacher->name ?? '-',
  //       'teacher_avatar' => $item->teacher->avatar ?? null,
  //       'class_date' => $item->scheduled_at,
  //       'started_at' => $item->start_time,
  //       'ended_at' => $item->end_time,
  //       'class_mode' => $item->class_mode,
  //       'class_link' => $item->meeting_link,
  //       'recorded_link' => $item->recording_url,
  //     ]);
  //   }

  //   // Sort latest by date
  //   $classes = $classes->sortByDesc('class_date');

  //   return view('company.mobile-app.statistics.spend-index', compact('classes', 'status'));
  // }


  public function show($id) {}

  public function edit($id, $type)
  {
    switch ($type) {
      case 'course':
        $item = CourseClass::with('course_data', 'durationAnalytics')->findOrFail($id);

        $class = [
          'id' => $item->id,
          'type' => 'course',
          'title' => $item->title,
          'parent_title' => $item->course_data->title ?? '-',
          'image' => $item->course_data->mian_image_url,
          'source' => $item->class_mode,
          'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
          'teacher_name' => $item->teacher->name ?? '-',
          'teacher_email' => $item->teacher->email ?? '-',
          'teacher_mobile' => $item->teacher->mobile ?? '-',
          'teacher_avatar' => $item->teacher->avatar ?? null,
          'class_date' => $item->scheduled_at,
          'started_at' => $item->start_time,
          'ended_at' => $item->end_time,
          'class_mode' => $item->type,
          'class_link' => $item->meeting_link,
          'recorded_link' => $item->recording_url,
        ];
        break;

      case 'workshop':
        $item = WorkshopClass::with('workshop', 'durationAnalytics')->findOrFail($id);

        $class = [
          'id' => $item->id,
          'type' => 'workshop',
          'title' => $item->title,
          'parent_title' => $item->workshop->title ?? '-',
          'image' => $item->workshop->mian_image_url,
          'source' => $item->class_mode,
          'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
          'teacher_name' => $item->teacher->name ?? '-',
          'teacher_email' => $item->teacher->email ?? '-',
          'teacher_mobile' => $item->teacher->mobile ?? '-',
          'teacher_avatar' => $item->teacher->avatar ?? null,
          'class_date' => $item->scheduled_at,
          'started_at' => $item->start_time,
          'ended_at' => $item->end_time,
          'class_mode' => $item->type,
          'class_link' => $item->meeting_link,
          'recorded_link' => $item->recording_url,
        ];
        break;

      case 'webinar':
        $item = Webinar::with('durationAnalytics')->findOrFail($id);

        $class = [
          'id' => $item->id,
          'type' => 'webinar',
          'title' => $item->title,
          'parent_title' => $item->title,
          'image' => $item->main_image_url,
          'source' => $item->class_mode,
          'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
          'teacher_name' => $item->teacher->name ?? '-',
          'teacher_email' => $item->teacher->email ?? '-',
          'teacher_mobile' => $item->teacher->mobile ?? '-',
          'teacher_avatar' => $item->teacher->avatar ?? null,
          'class_date' => $item->scheduled_at,
          'started_at' => $item->start_time,
          'ended_at' => $item->end_time,
          'class_mode' => $item->type,
          'class_link' => $item->meeting_link,
          'recorded_link' => $item->recording_url,
        ];
        break;

      case 'demo':
        $item = DemoClass::with('durationAnalytics')->findOrFail($id);

        $class = [
          'id' => $item->id,
          'type' => 'demo',
          'title' => $item->title,
          'parent_title' => $item->title,
          'image' => $item->main_image_url,
          'source' => $item->source,
          'spend_duration' => $item->durationAnalytics?->spend_duration ?? 0,
          'teacher_name' => $item->teacher->name ?? '-',
          'teacher_email' => $item->teacher->email ?? '-',
          'teacher_mobile' => $item->teacher->mobile ?? '-',
          'teacher_avatar' => $item->teacher->avatar ?? null,
          'class_date' => $item->scheduled_at,
          'started_at' => $item->start_time,
          'ended_at' => $item->end_time,
          'class_mode' => $item->class_mode,
          'class_link' => $item->meeting_link,
          'recorded_link' => $item->recording_url,
        ];
        break;

      default:
        abort(404);
    }
    $company_id = auth()->user()->company_id;
    $statisticsSpend = SpendTimeClassAnalytics::where('class_id', $id)->where('type', $type)->where('company_id', $company_id)->first();

    return view('company.mobile-app.statistics.spend-time-edit', compact('class', 'statisticsSpend'));
  }

  public function update(Request $request, $id, $type)
  {
    $company_id = auth()->user()->company_id;
    $statisticsSpend = SpendTimeClassAnalytics::where('class_id', $id)->where('type', $type)->where('company_id', $company_id)->first();

    if ($statisticsSpend) {
      $statisticsSpend->spend_duration = $request->spend_duration;
      $statisticsSpend->status = $request->status;
      $statisticsSpend->updated_by = auth()->user()->id;
      $statisticsSpend->save();
    } else {
      $statisticsSpend = new SpendTimeClassAnalytics();
      $statisticsSpend->spend_duration = $request->spend_duration;
      $statisticsSpend->type   = $type;
      $statisticsSpend->class_id = $id;
      $statisticsSpend->status = $request->status;
      $statisticsSpend->company_id = $company_id;
      $statisticsSpend->verified_by = auth()->user()->id;
      $statisticsSpend->save();
    }
    return redirect()->route('company.app.statistics-spend.index', ['status' => 'pending'])->with('success', 'Updated successfully');
  }
}
