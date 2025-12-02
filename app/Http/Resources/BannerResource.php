<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        // user id from controller
        $user_id = $request->user_id;

        // check booking
        $userBooking = $this->requestBanner?->where('user_id', $user_id)->first();

        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' => $this->description,

            // images
            'main_image' => $this->main_id ? asset('storage/'.$this->main_image_url) : null,
            'thumb'      => $this->thumb_id ? asset('storage/'.$this->thumbnail_url) : null,

            // priority & type
            'priority_order' => (int) $this->priority,
            'banner_type'    => $this->banner_type,

            // CTA
            'cta_label'  => $this->ct_label,
            'cta_action' => $this->ct_action,

            // user booking check
            'is_booked' => $userBooking ? true : false,

            // last booked datetime
            'last_booked_at' => $userBooking->booked_at ?? null,
        ];
    }
}
