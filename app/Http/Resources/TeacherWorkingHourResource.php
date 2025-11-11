<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherWorkingHourResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'time_slot' => $this->time_slot ?? '',
        ];
    }
}
