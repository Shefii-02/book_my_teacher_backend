<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassLinkResource extends JsonResource
{
  public function toArray($request)
  {


        $now = Carbon::now();

        // Default status
        $classStatus = 'pending';

        if ($this->status == 'scheduled') {
            if ($now->lt($this->start_date_time)) {
                $classStatus = 'upcoming';
            } elseif ($now->between($this->start_date_time, $this->end_date_time)) {
                $classStatus = 'ongoing';
            } elseif ($now->gt($this->end_date_time)) {
                $classStatus = 'completed';
            }
        }


    return [
      'id' => $this->id,
      'title' => $this->title,
      'status' => $classStatus,
      // 'teacher' => $this->teachers->pluck('name')->first(),
      'teacher' => optional(
        $this->course?->teachers?->first()
      )->name,
      'source'    => $this->class_mode,
      'date_time' => $this->start_time,
      'start_date_time' => $this->start_date_time,
      'end_date_time' => $this->end_date_time,
      'recorded_video' => $this->recording_url,
      'join_link' => $this->meeting_link,
    ];
  }
}
