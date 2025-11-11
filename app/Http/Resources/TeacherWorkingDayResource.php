<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherWorkingDayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'day' => $this->day,
        ];
    }
}
