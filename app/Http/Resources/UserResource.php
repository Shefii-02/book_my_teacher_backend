<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  protected $accountMsg;
  protected $steps;

  public function __construct($resource, $accountMsg = null, $steps = [])
  {
    parent::__construct($resource);
    $this->accountMsg = $accountMsg;
    $this->steps = $steps;
  }

  public function toArray($request)
  {

    return [
      'id' => $this->id,
      'name' => $this->name,
      'mobile' => $this->mobile,
      'mobile_verified' => $this->mobile_verified,
      'email' => $this->email,
      'email_verified_at' => $this->email_verified_at,
      'acc_type' => $this->acc_type,
      'last_login' => $this->last_login,
      'last_activation' => $this->last_activation,
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
      'professional' => new TeacherProfessionalResource($this->professionalInfo) ?? [],
      'subjects' => TeacherSubjectResource::collection($this->subjects) ?? [],
      'grades' => TeacherGradeResource::collection($this->teacherGrades) ?? [],
      'working_days' => TeacherWorkingDayResource::collection($this->workingDays) ?? [],
      'working_hours' => TeacherWorkingHourResource::collection($this->workingHours) ?? [],
      'referral_code' => $this->referral_code ?? '',
      'account_status'    => $this->account_status,
      'account_msg' => $this->accountMsg ?? '',
      'steps' => $this->steps ?? [],
    ];
  }
}
