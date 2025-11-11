<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherSubjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'subject' => $this->subject ?? '',
        ];
    }
}
