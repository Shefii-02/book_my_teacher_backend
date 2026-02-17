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

class StatisticsWatchController extends Controller
{

  public function index(Request $request)
  {
    $company_id = auth()->user()->company_id;
    $status = $request->status ?? 'pending'; // pending | approved


    $classes = collect();

    /*
        |--------------------------------------------------------------------------
        | COURSE
        |--------------------------------------------------------------------------
        */
    $courseClasses = CourseClass::with(['course_data', 'durationAnalytics'])
      ->whereHas('course_data', fn($q) => $q->where('company_id', $company_id))
      ->get();

    foreach ($courseClasses as $item) {
      $analytics = $item->durationAnalytics;

      // Only approved spend time
      if (!$analytics || $analytics->status !== 'approved') continue;

      $classes->push($this->formatCard($item, 'course', [
        'parent' => $item->course_data->title ?? '-',
        'image' => $item->course_data->mian_image_url ?? null,
        'mode' => $item->type,
        'source' => $item->class_mode,
      ], $analytics));
    }

    /*
        |--------------------------------------------------------------------------
        | WORKSHOP
        |--------------------------------------------------------------------------
        */
    $workshopClasses = WorkshopClass::with(['workshop', 'durationAnalytics'])
      ->whereHas('workshop', fn($q) => $q->where('company_id', $company_id))
      ->get();

    foreach ($workshopClasses as $item) {
      $analytics = $item->durationAnalytics;
      if (!$analytics || $analytics->status !== 'approved') continue;

      $classes->push($this->formatCard($item, 'workshop', [
        'parent' => $item->workshop->title ?? '-',
        'image' => $item->workshop->mian_image_url ?? null,
        'mode' => $item->type,
        'source' => $item->class_mode,
      ], $analytics));
    }

    /*
        |--------------------------------------------------------------------------
        | WEBINAR
        |--------------------------------------------------------------------------
        */
    $webinars = Webinar::with(['durationAnalytics'])
      ->where('company_id', $company_id)
      ->get();

    foreach ($webinars as $item) {
      $analytics = $item->durationAnalytics;
      if (!$analytics || $analytics->status !== 'approved') continue;

      $classes->push($this->formatCard($item, 'webinar', [
        'parent' => $item->title,
        'image' => $item->main_image_url,
        'mode' => $item->type,
        'source' => $item->class_mode,
      ], $analytics));
    }

    /*
        |--------------------------------------------------------------------------
        | DEMO
        |--------------------------------------------------------------------------
        */
    $demos = DemoClass::with(['durationAnalytics'])
      ->where('company_id', $company_id)
      ->get();

    foreach ($demos as $item) {
      $analytics = $item->durationAnalytics;
      if (!$analytics || $analytics->status !== 'approved') continue;

      $classes->push($this->formatCard($item, 'demo', [
        'parent' => $item->title,
        'image' => $item->main_image_url,
        'mode' => $item->class_mode,
        'source' => $item->source,
      ], $analytics));
    }

    /*
        |--------------------------------------------------------------------------
        | TAB FILTER
        |--------------------------------------------------------------------------
        */
    if ($status === 'pending') {
      $classes = $classes->filter(fn($c) => empty($c['watch_duration']));
    } else {
      $classes = $classes->filter(fn($c) => !empty($c['watch_duration']));
    }

    $classes = $classes->sortByDesc('class_date');

    return view('company.mobile-app.statistics.watch-index', compact('classes', 'status'));
  }

  /*
    |--------------------------------------------------------------------------
    | FORMAT CARD HELPER
    |--------------------------------------------------------------------------
    */
  private function formatCard($item, $type, $extra, $analytics)
  {
    return [
      'id' => $item->id,
      'type' => $type,
      'title' => $item->title,
      'parent_title' => $extra['parent'],
      'image' => $extra['image'],
      'source' => $extra['source'],
      'spend_duration' => $analytics->spend_duration ?? 0,
      'watch_duration' => $analytics->watch_duration ?? 0,
      'teacher_name' => $item->teacher->name ?? '-',
      'teacher_avatar' => $item->teacher->avatar ?? null,
      'class_date' => $item->scheduled_at,
      'started_at' => $item->start_time,
      'ended_at' => $item->end_time,
      'class_mode' => $extra['mode'],
      'class_link' => $item->meeting_link,
      'recorded_link' => $item->recording_url,
    ];
  }

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

    return view('company.mobile-app.statistics.watch-time-edit', compact('class', 'statisticsSpend'));
  }

  public function update(Request $request, $id, $type)
  {
    $company_id = auth()->user()->company_id;
    $statisticsSpend = SpendTimeClassAnalytics::where('class_id', $id)->where('type', $type)->where('company_id', $company_id)->first();

    if ($statisticsSpend) {
      $statisticsSpend->watch_duration = $request->watch_duration;
      $statisticsSpend->updated_by = auth()->user()->id;
      $statisticsSpend->save();
    } else {
      return redirect()->back()->with('error', 'Class not founded');
    }
    return redirect()->route('company.app.statistics-watch.index', ['status' => 'pending'])->with('success', 'Updated successfully');
  }
}
