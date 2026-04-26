<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use League\OAuth1\Client\Server\Tumblr;

class CourseClassLinkResource extends JsonResource
{
  public function toArray($request)
  {


        $now = Carbon::now();

        // Default status
        $classStatus = 'pending';

        if ($this->status == '1') {
            if ($now->lt($this->start_time)) {
                $classStatus = 'upcoming';
            } elseif ($now->between($this->start_time, $this->end_time)) {
                $classStatus = 'ongoing';
            } elseif ($now->gt($this->end_time)) {
                $classStatus = 'completed';
            }
        }


    return [
      'id' => (string)$this->id,
      'title' => $this->title,
      'status' => $classStatus,
      // 'teacher' => $this->teachers->pluck('name')->first(),
      'teacher' => optional(
        $this->course?->teachers?->first()
      )->name,
      'source'    => $this->class_mode,
      'date_time' => $this->start_time,
      'start_date_time' => $this->start_time,
      'end_date_time' => $this->end_time,
      'recorded_video' => $this->recording_url,
      'join_link' => $this->meeting_link,
      'attendance_taken' => ture,
      'total_students' => 4,
      'present_count' => 4,
      'actual_duration' => '4',

    ];
  }
}
