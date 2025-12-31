<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WebinarClassLinkResource extends JsonResource
{
  public function toArray($request)
  {
        $now = Carbon::now();

        // Default status
        $classStatus = 'pending';

        if ($this->status == 'scheduled') {
            if ($now->lt($this->started_at)) {
                $classStatus = 'upcoming';
            } elseif ($now->between($this->started_at, $this->ended_at)) {
                $classStatus = 'ongoing';
            } elseif ($now->gt($this->ended_at)) {
                $classStatus = 'completed';
            }
        }


    return [
      'id' => $this->id,
      'title' => $this->title,
      'status' => $classStatus,
      // 'teacher' => $this->teachers->pluck('name')->first(),
      'teacher' => $this->host?->name ?? '',
      'source'    => 'gmeet',
      'date_time' => date('Y-m-d H:i:s', strtotime($this->started_at)),
      'start_date_time'    => date('Y-m-d H:i:s', strtotime($this->started_at)),
      'end_date_time'      => date('Y-m-d H:i:s', strtotime($this->ended_at)),
      'recorded_video' => $this->recording_url,
      'join_link' => $this->meeting_url,
    ];
  }
}
