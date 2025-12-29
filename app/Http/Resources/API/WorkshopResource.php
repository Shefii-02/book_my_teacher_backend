<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id'            => $this->id,
      'title'         => $this->title,
      'description'   => $this->description,
      'slug'          => $this->slug,


      'thumbnail_url' => $this->thumbnail_image ? asset('storage/' . $this->thumbnail_image) : null,
      'main_image_url' => $this->main_image ? asset('storage/' . $this->main_image) : null,


      'started_at'    => $this->started_at,
      'ended_at'      => $this->ended_at,
      'registration_end_at' => $this->registration_end_at,

      // 💰 Pricing
      'actual_price'  => $this->actual_price,
      'discount_price' => $this->discount_price,
      'net_price'     => $this->net_price,

      // 🧩 Workshop Features
      'max_participants' => $this->max_participants,
      'is_record_enabled' => (bool) $this->is_record_enabled,
      'is_chat_enabled'   => (bool) $this->is_chat_enabled,
      'is_screen_share_enabled' => (bool) $this->is_screen_share_enabled,
      'is_whiteboard_enabled'   => (bool) $this->is_whiteboard_enabled,
      'is_camera_enabled'       => (bool) $this->is_camera_enabled,
      'is_audio_only_enabled'   => (bool) $this->is_audio_only_enabled,

      'status'        => $this->status,
      'is_public'     => (bool) $this->is_public,

      'is_enrolled'   => (bool) ($this->is_enrolled ?? false),
      // 'is_enrolled' => $this->whenLoaded('registrations')->count() ? true : false,
    ];
  }
}
