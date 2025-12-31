<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassLinkResource extends JsonResource
{

  public function toArray($request)
  {
    $now = Carbon::now();

    $startDateTime = Carbon::parse(
      $this->scheduled_at . ' ' . $this->start_time
    );

    $endDateTime = Carbon::parse(
      $this->scheduled_at . ' ' . $this->end_time
    );

    return [
      'id' => $this->id,
      'title' => $this->title,
      'status' => $this->status == 'scheduled' ? 'scheduled' : 'pending',
      // 'teacher' => $this->teachers->pluck('name')->first(),
      'teacher' => optional(
        $this->course?->teachers->first()
      )->name,
      'source'    => $this->class_mode,
      'date_time' => $startDateTime,
      'end_date_time'  => $endDateTime,
      'recorded_video' => $this->recording_url,
      'join_link' => $this->meeting_link,
    ];
  }
}
