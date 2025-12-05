<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
  public function toArray($request)
  {

    return [
      'id' => (int) $this->id,
      'name' => $this->name,
      'qualification' => $this->qualifications ?? '',
      'subjects'      => $this->whenLoaded('selectedSubjects', function () {
        return $this->subjects->pluck('name')->implode(',');
      }),
      'courses' => [],
      'ranking' => intval($this->ranking ?? '1'),
      'rating' => floatval($this->rating ?? '4.5'),
      'imageUrl' => asset($this->thumbnail_url),
      'description' => $this->description,
      'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
    ];
  }
}
