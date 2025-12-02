<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => (string) $this->id,
      'name' => $this->name,
      'description' => $this->description,
      'main_image' => asset("/assets/mobile-app/bg/full-bg.jpg") ?? asset($this->main_image),
      'image' => asset($this->icon_url),
      // Nested Reviews
      'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
      // Nested Teachers
      'available_teachers' => AvailableTeacherResource::collection(
        $this->whenLoaded('providingTeachers')->map->teacher
      ),
    ];
  }
}
