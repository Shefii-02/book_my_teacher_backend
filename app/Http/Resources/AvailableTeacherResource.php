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
            'qualification' => $this->qualification,
            'subjects' => $this->subjects,
            'ranking' => $this->ranking,
            'rating' => $this->rating,
            'imageUrl' => asset($this->image_url),
        ];
    }
}
