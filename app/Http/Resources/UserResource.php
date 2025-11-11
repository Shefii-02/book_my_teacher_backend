<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'acc_type' => $this->acc_type,
            'status' => (int) $this->status,
            'account_status' => $this->account_status,
            'current_account_stage' => $this->current_account_stage,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // 🔗 Linked teacher data
            'personal' => new TeacherPersonalResource($this->whenLoaded('personal')),
            'subjects' => TeacherSubjectResource::collection($this->whenLoaded('subjects')),
            'grades' => TeacherGradeResource::collection($this->whenLoaded('grades')),
            'working_days' => TeacherWorkingDayResource::collection($this->whenLoaded('workingDays')),
            'working_hours' => TeacherWorkingHourResource::collection($this->whenLoaded('workingHours')),
        ];
    }
}
