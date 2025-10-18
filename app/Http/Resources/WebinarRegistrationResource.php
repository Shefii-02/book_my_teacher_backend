<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebinarRegistrationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'webinar_id'=> $this->webinar_id,
            'name'=> $this->name,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'checked_in'=> $this->checked_in,
            'created_at'=> $this->created_at
        ];
    }
}
