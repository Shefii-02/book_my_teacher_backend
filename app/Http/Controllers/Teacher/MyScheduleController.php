<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DemoClass;
use App\Models\TeacherClass;
use App\Models\Webinar;
use App\Models\WorkshopClass;
use Carbon\Carbon;

class MyScheduleController extends Controller
{
  public function index()
  {
    $user = auth()->user();

    $start = Carbon::today();
    $end   = Carbon::today()->addMonths(2)->endOfMonth();

    /*
        |--------------------------------------------------------------------------
        | WEBINARS
        |--------------------------------------------------------------------------
        */

    $webinars = Webinar::where('host_id', $user->id)
      ->whereBetween('started_at', [$start, $end])
      ->get()
      ->map(fn($item) => $this->directFormatEvent($item, 'Webinar'));

    /*
        |--------------------------------------------------------------------------
        | WORKSHOPS
        |--------------------------------------------------------------------------
        */

    $workshops = WorkshopClass::whereHas('workshop', function ($q) use ($user) {

      $q->where('host_id', $user->id);
    })
      ->whereBetween('scheduled_at', [$start, $end])
      ->get()
      ->map(fn($item) => $this->formatEvent($item, 'Workshop'));

    /*
        |--------------------------------------------------------------------------
        | COURSE CLASSES
        |--------------------------------------------------------------------------
        */

    $courses = TeacherClass::where('teacher_id', $user->id)
      ->with([
        'course_classes'
      ])
      ->get()
      ->flatMap(function ($teacherClass) use ($start, $end) {

        return $teacherClass->course_classes
          ->whereBetween('scheduled_at', [$start, $end])
          ->map(function ($class) {

            return $this->formatEvent($class, 'Course');
          });
      });

    /*
        |--------------------------------------------------------------------------
        | DEMO CLASSES
        |--------------------------------------------------------------------------
        */

    $demoClasses = DemoClass::where('host_id', $user->id)
      ->whereBetween('started_at', [$start, $end])
      ->get()
      ->map(fn($item) => $this->directFormatEvent($item, 'Demo'));

    /*
        |--------------------------------------------------------------------------
        | MERGE EVENTS
        |--------------------------------------------------------------------------
        */

    $events = collect()
      ->merge($webinars)
      ->merge($workshops)
      ->merge($courses)
      ->merge($demoClasses)
      ->sortBy('started_at_raw')
      ->values();

    /*
        |--------------------------------------------------------------------------
        | COUNTS
        |--------------------------------------------------------------------------
        */

    $data['total'] = $events->count();

    $data['today'] = $events->filter(function ($event) {

      return Carbon::parse($event['started_at_raw'])->isToday();
    })->count();

    $data['upcoming'] = $events->filter(function ($event) {

      return Carbon::parse($event['started_at_raw'])->isFuture();
    })->count();

    $data['completed'] = $events->filter(function ($event) {

      return Carbon::parse($event['ended_at_raw'])->isPast();
    })->count();

    $data['live'] = $events->filter(function ($event) {

      return now()->between(
        Carbon::parse($event['started_at_raw']),
        Carbon::parse($event['ended_at_raw'])
      );
    })->count();

    return view(
      'teacher.my_schedules.index',
      compact('events', 'data')
    );
  }

  /*
    |--------------------------------------------------------------------------
    | FORMAT DIRECT EVENTS
    |--------------------------------------------------------------------------
    */

  private function directFormatEvent($model, string $type): array
  {
    return [

      'schedule_date' => Carbon::parse($model->started_at)->format('d M Y'),

      'started_at' => Carbon::parse($model->started_at)->format('d M Y h:i A'),

      'ended_at' => Carbon::parse($model->ended_at)->format('d M Y h:i A'),

      'started_at_raw' => $model->started_at,

      'ended_at_raw' => $model->ended_at,

      'title' => $model->title,

      'description' => $model->description,

      'type' => $type,

      'mode' => 'Online',

      'source' => $model->provider?->name ?? 'Internal',

      'class_link' => $model->meeting_url,

      'students_count' => $model->registrations?->count() ?? 0,

      'status' => $model->status,

    ];
  }

  /*
    |--------------------------------------------------------------------------
    | FORMAT COURSE / WORKSHOP EVENTS
    |--------------------------------------------------------------------------
    */

  private function formatEvent($model, string $type): array
  {
    return [

      'schedule_date' => Carbon::parse($model->started_at)->format('d M Y'),

      'started_at' => Carbon::parse($model->started_at)->format('d M Y h:i A'),

      'ended_at' => Carbon::parse($model->ended_at)->format('d M Y h:i A'),

      'started_at_raw' => $model->started_at,

      'ended_at_raw' => $model->ended_at,

      'title' => $model->title,

      'description' => $model->description,

      'type' => $type,

      'mode' => $model->class_mode ?? 'Online',

      'source' => $model->provider?->name ?? 'Internal',

      'class_link' => $model->meeting_link,

      'students_count' => $model->courses
        ? $model->courses?->registrations?->count()
        : ($model->workshop?->registrations?->count() ?? 0),

      'status' => $model->status,

    ];
  }


  // Controller
  public function todayClasses()
  {
    $user = auth()->user();

    $todayStart = Carbon::today()->startOfDay();
    $todayEnd   = Carbon::today()->endOfDay();
    $now        = now();

    /*
        |--------------------------------------------------------------------------
        | WEBINARS
        |--------------------------------------------------------------------------
        */

    $webinars = Webinar::where('host_id', $user->id)
      ->whereBetween('started_at', [$todayStart, $todayEnd])
      ->get()
      ->map(function ($item) use ($now) {

        return [
          'title' => $item->title,
          'description' => $item->description,
          'type' => 'Webinar',

          'start_time' => Carbon::parse($item->started_at),
          'end_time' => Carbon::parse($item->ended_at),

          'meeting_link' => $item->meeting_url,
          'recording_url' => $item->recording_url,

          'students_count' => $item->registrations?->count() ?? 0,

          'status' => $this->getStatus(
            $item->started_at,
            $item->ended_at,
            $now
          ),
        ];
      });

    /*
        |--------------------------------------------------------------------------
        | WORKSHOPS
        |--------------------------------------------------------------------------
        */

    $workshops = WorkshopClass::whereHas('workshop', function ($q) use ($user) {

      $q->where('host_id', $user->id);
    })
      ->whereBetween('scheduled_at', [$todayStart, $todayEnd])
      ->get()
      ->map(function ($item) use ($now) {

        return [
          'title' => $item->title,
          'description' => $item->description,
          'type' => 'Workshop',

          'start_time' => Carbon::parse($item->start_time),
          'end_time' => Carbon::parse($item->end_time),

          'meeting_link' => $item->meeting_link,
          'recording_url' => $item->recording_url,

          'students_count' => $item->workshop?->registrations?->count() ?? 0,

          'status' => $this->getStatus(
            $item->start_time,
            $item->end_time,
            $now
          ),
        ];
      });

    /*
        |--------------------------------------------------------------------------
        | COURSE CLASSES
        |--------------------------------------------------------------------------
        */

    $courses = TeacherClass::where('teacher_id', $user->id)
      ->with('course_classes.courses.registrations')
      ->whereHas('course_classes', function ($q) use ($todayStart, $todayEnd) {

        $q->whereBetween('scheduled_at', [$todayStart, $todayEnd]);
      })
      ->get()
      ->flatMap(function ($teacherClass) use ($now) {

        return $teacherClass->course_classes->map(function ($item) use ($now) {

          return [
            'title' => $item->title,
            'description' => $item->description,
            'type' => 'Course Class',

            'start_time' => Carbon::parse($item->start_time),
            'end_time' => Carbon::parse($item->end_time),

            'meeting_link' => $item->meeting_link,
            'recording_url' => $item->recording_url,

            'students_count' => $item->courses?->registrations?->count() ?? 0,

            'status' => $this->getStatus(
              $item->start_time,
              $item->end_time,
              $now
            ),
          ];
        });
      });

    /*
        |--------------------------------------------------------------------------
        | DEMO CLASSES
        |--------------------------------------------------------------------------
        */

    $demoClasses = DemoClass::where('host_id', $user->id)
      ->whereBetween('started_at', [$todayStart, $todayEnd])
      ->get()
      ->map(function ($item) use ($now) {

        return [
          'title' => $item->title,
          'description' => $item->description,
          'type' => 'Demo Class',

          'start_time' => Carbon::parse($item->started_at),
          'end_time' => Carbon::parse($item->ended_at),

          'meeting_link' => $item->meeting_url,
          'recording_url' => $item->recording_url,

          'students_count' => $item->registrations?->count() ?? 0,

          'status' => $this->getStatus(
            $item->started_at,
            $item->ended_at,
            $now
          ),
        ];
      });

    /*
        |--------------------------------------------------------------------------
        | MERGE
        |--------------------------------------------------------------------------
        */

    $events = collect()
      ->merge($webinars)
      ->merge($workshops)
      ->merge($courses)
      ->merge($demoClasses)
      ->sortBy('start_time')
      ->values();

    /*
        |--------------------------------------------------------------------------
        | COUNTS
        |--------------------------------------------------------------------------
        */

    $data['total'] = $events->count();

    $data['live'] = $events->where('status', 'live')->count();

    $data['upcoming'] = $events->where('status', 'upcoming')->count();

    $data['completed'] = $events->where('status', 'completed')->count();

    return view(
      'teacher.my_schedules.today_classes',
      compact('events', 'data')
    );
  }

  private function getStatus($start, $end, $now)
  {
    $start = Carbon::parse($start);
    $end = Carbon::parse($end);

    if ($now->between($start, $end)) {
      return 'live';
    }

    if ($now->lt($start)) {
      return 'upcoming';
    }

    return 'completed';
  }
}
