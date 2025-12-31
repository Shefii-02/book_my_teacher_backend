<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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

        // Default status
        $classStatus = 'pending';

        if ($this->status == 1) {
            if ($now->lt($startDateTime)) {
                $classStatus = 'upcoming';
            } elseif ($now->between($startDateTime, $endDateTime)) {
                $classStatus = 'ongoing';
            } elseif ($now->gt($endDateTime)) {
                $classStatus = 'completed';
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $classStatus,

            'teacher' => optional(
                $this->course?->teachers->first()
            )->name,

            'source' => $this->class_mode,

            'date_time' => $startDateTime->format('Y-m-d H:i:s'),
            'start_time' => $startDateTime->format('H:i:s'),
            'end_time' => $endDateTime->format('H:i:s'),

            'recorded_video' => $this->recording_url,
            'join_link' => $this->meeting_link,
        ];
    }
}
