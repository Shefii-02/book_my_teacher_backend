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
            'ranking' => $this->ranking ?? '1',
            'rating' => $this->rating ?? '5.0',
            'imageUrl' => asset($this->image_url),
        ];
    }
}
