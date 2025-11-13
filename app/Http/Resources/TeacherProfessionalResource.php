<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherProfessionalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'profession' => $this->profession ?? '',
            'ready_to_work' => $this->ready_to_work ?? '',
            'teaching_mode' => $this->teaching_mode ?? '',
            'offline_exp' => $this->offline_exp ?? '',
            'online_exp' => $this->online_exp ?? '',
            'home_exp' => $this->home_exp ?? ''
        ];
    }
}
