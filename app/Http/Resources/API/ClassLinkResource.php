<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
  public function toArray($request)
  {

    return [
      'id' => '1',
      'title' => 'Welcome & Setup',
      'status' => 'completed',
      'teacher' => 'Mark Allen',
      'source'    => 'youtube',
      'date_time' => '2025-10-01T10:00:00Z',
      'recorded_video' => 'https://youtu.be/iLnmTe5Q2Qw',
      'join_link' => '',
    ];
  }
}
