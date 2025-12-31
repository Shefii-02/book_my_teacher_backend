<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassLinkResource extends JsonResource
{
  public function toArray($request)
  {

    return [
      'id' => $this->id,
      'title' => $this->title,
      'status' => $this->status == 1 ? 'scheduled' : 'pending',
      // 'teacher' => $this->teachers->pluck('name')->first(),
      'teacher' => optional(
        $this->course?->teachers->first()
      )->name,
      'source'    => $this->class_mode,
      'date_time' => $this->start_date_time?->format('Y-m-d H:i:s'),
      'recorded_video' => $this->recording_url,
      'join_link' => $this->meeting_link,
    ];
  }
}
