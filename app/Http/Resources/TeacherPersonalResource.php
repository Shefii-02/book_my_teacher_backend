<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherPersonalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : asset('default-avatar.png'),
            'full_name' => $this->full_name,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'district' => $this->district,
            'state' => $this->state,
            'country' => $this->country,
        ];
    }
}
