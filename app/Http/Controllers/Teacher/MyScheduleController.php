<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DemoClass;
use App\Models\TeacherClass;
use App\Models\Webinar;
use App\Models\Workshop;
use App\Models\WorkshopClass;
use Carbon\Carbon;

class MyScheduleController extends Controller
{
  public function index()
  {
    $user = auth()->user();

    $month = now()->format('Y-m');
    // $start = Carbon::parse($month)->subMonths(2)->startOfMonth();
    $start = Carbon::today();

    $end   = Carbon::parse($month)->addMonths(2)->endOfMonth();

    /* ------------------------------
         | Webinars
         |------------------------------*/
    $webinars = Webinar::
      where('host_id', $user->id)->
      // whereBetween('started_at', [$start, $end])
      // ->
      get()
      ->map(fn($w) => $this->directFormatEvent($w, 'Webinar'));


    /* ------------------------------
         | Workshops
         |------------------------------*/
    $workshops = WorkshopClass::
      whereHas('workshop', function ($q) use ($user) {
        $q->where('host_id', $user->id);
      })->
      // whereBetween('scheduled_at', [$start, $end])->
      get()
      ->map(fn($w) => $this->formatEvent($w, 'Workshop'));

    /* ------------------------------
         | Course / Individual Classes
         |------------------------------*/
    $courses = TeacherClass::where('teacher_id', $user->id)
      ->whereHas('course_classes', function ($q) use ($start, $end) {
        $q->whereBetween('scheduled_at', [$start, $end]);
      })
      ->with(['course_classes' => function ($q) use ($start, $end) {
        $q->whereBetween('scheduled_at', [$start, $end]);
      }])
      ->get()
      ->flatMap(function ($teacherClass) {
        return $teacherClass->course_classes->map(function ($class) {
          return $this->formatEvent($class, 'Course Class');
        });
      });


    /* ------------------------------
         | Demo Classes
         |------------------------------*/
    $demoClasses = DemoClass::
      // where('host_id', $user->id)->
      whereBetween('started_at', [$start, $end])
      ->get()
      ->map(fn($d) => $this->directFormatEvent($d, 'Demo Class'));

    /* ------------------------------
         | Merge & Group by Date
         |------------------------------*/
    $events = collect()
      ->merge($webinars)
      ->merge($workshops)
      ->merge($courses)
      ->merge($demoClasses)
      ->groupBy('date')
      ->sortKeys();

    $month      = $month;
    $first_day = $start->toDateString();
    $last_day  = $end->toDateString();
    $events    = $events;


    return view('teacher.my_schedules.index', compact('first_day', 'last_day', 'events'));
  }


  private function directFormatEvent($model, string $type): array
  {

    return [
      "schedule_date" => Carbon::parse($model->started_at)->format('d-m-Y'),
      "started_at"    => Carbon::parse($model->started_at)->format('d-m-Y H:i'),
      "ended_at"      => Carbon::parse($model->started_at)->format('d-m-Y H:i'),
      "title"         => $model->title,
      "description"   => $model->description,
      "type"          => $type,
      "mode"          => 'online',
      "source"        => $model->provider?->name,
      "class_link"    => $model->meeting_url,
      "students_count" => $model->registrations?->count(),
    ];
  }

  private function formatEvent($model, string $type): array
  {

    return [
      "schedule_date" => Carbon::parse($model->started_at)->format('d-m-Y'),
      "started_at"    => Carbon::parse($model->started_at)->format('d-m-Y H:i'),
      "ended_at"      => Carbon::parse($model->started_at)->format('d-m-Y H:i'),
      "title"         => $model->title,
      "description"   => $model->description,
      "type"          => $type,
      "mode"          => 'online',
      "source"        => $model->provider?->name,
      "class_link"    => $model->meeting_link,
      "students_count" => $model->courses ? $model->courses?->registrations?->count() : $model->workshop?->registrations?->count(),
    ];
  }

  // private function formatEvent($model, string $type): array
  // {

  //   return [

  //     "schedule_date" => '',
  //     "started_at"    => '',
  //     "ended_at"      => '',
  //     "type"          => '',
  //     "mode"          => '',
  //     "source"        => '',
  //     "class_link"          => '',
  //     "students_count" => '',

  //     "id" => $model->id,
  //     "date" => Carbon::parse($model->started_at)->format('d-m-Y'),

  //     "type" => $type,
  //     "topic" => $model->title ?? $model->topic,
  //     "description" => $model->description,

  //     "time_start" => Carbon::parse($model->started_at)->format('d-m-Y H:i'),
  //     "time_end" => Carbon::parse($model->ended_at)->format('d-m-Y H:i'),
  //     "duration" => $model->duration,

  //     "course_id" => $model->course_id ?? null,

  //     "class_link" => $model->meeting_link ?? null,
  //     "meeting_password" => $model->meeting_password ?? null,

  //     "host_name" => $model->host->name ?? $model->teacher->name ?? 'Admin',

  //     "class_status" => $model->status, // upcoming | live | completed
  //     "attendance_required" => (bool) ($model->attendance_required ?? false),

  //     "subject_name" => $model->subject->name ?? null,
  //     "thumbnail_url" => $model->thumbnail ?? null,

  //     "class_type" => $model->mode ?? 'online',
  //     "source" => $model->source ?? '',
  //     "location" => $model->location ?? 'Online',

  //     "students" => $model->students_count ?? 0,
  //   ];
  // }
}
