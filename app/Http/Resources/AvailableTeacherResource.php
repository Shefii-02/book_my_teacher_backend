<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvailableTeacherResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => (int) $this->id,
      'name' => $this->name,
      'qualification' => $this->qualifications ?? '',
      'subjects' => is_array($this->subjects) ? implode(',',$this->subjects) : '',
      // 'subjects' =>  $this->whenLoaded('selectedSubjects', function () {
      //   return $this->selectedSubjects->pluck('name')->implode(',');
      // }),
      'ranking' => intval($this->ranking ?? '1'),
      'rating' => floatval($this->rating ?? '4.5'),
      'imageUrl' => asset($this->thumbnail_url),
    ];
  }
}
