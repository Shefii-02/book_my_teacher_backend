<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        // $accountStatusResponse = accountStatus($this);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'mobile_verified' => $this->mobile_verified,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'acc_type' => $this->acc_type,
            'last_login'=> $this->last_login,
            'last_activation'=> $this->last_activation,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'district' => $this->district,
            'state' => $this->state,
            'country' => $this->country,
            'status' => (int) $this->status,
            'profile_fill' => $this->profile_fill,
            'account_status' => $this->account_status,
            'current_account_stage' => $this->current_account_stage,
            'interview_at' => $this->interview_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'notes' => $this->notes,
            'avatar_url' => $this->avatar_url,
            'cv_url' => $this->cv_url,

            // 🔗 Linked teacher data
            'personal' => new TeacherPersonalResource($this->whenLoaded('personal')),
            'subjects' => TeacherSubjectResource::collection($this->whenLoaded('subjects')),
            'grades' => TeacherGradeResource::collection($this->whenLoaded('grades')),
            'working_days' => TeacherWorkingDayResource::collection($this->whenLoaded('workingDays')),
            'working_hours' => TeacherWorkingHourResource::collection($this->whenLoaded('workingHours')),
            'referral_code' => 'BMT-9834',
            'account_status'    => $this->account_status,
            // 'account_msg'       => $accountStatusResponse['accountMsg'],
            // 'steps'             => $accountStatusResponse['steps'],
             'account_msg'   => '',
             'steps'         => [],
        ];
    }
}
