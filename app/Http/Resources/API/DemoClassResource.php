<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemoClassResource extends JsonResource
{
  public function toArray(Request $request): array
  {


    $now = Carbon::now();

    // Default status
    $classStatus = 'pending';

    if ($this->status == 'scheduled') {
      if ($now->lt($this->start_date_time)) {
        $classStatus = 'upcoming';
      } elseif ($now->between($this->start_date_time, $this->end_date_time)) {
        $classStatus = 'ongoing';
      } elseif ($now->gt($this->end_date_time)) {
        $classStatus = 'completed';
      }
    }

    return [
      'id'            => $this->id,
      'title'         => $this->title,
      'description'   => $this->description,
      'slug'          => $this->slug,

      'thumbnail_url' => $this->thumbnail_image ? asset('storage/' . $this->thumbnail_image) : null,
      'main_image_url' => $this->thumbnail_image ? asset('storage/' . $this->thumbnail_image) : null,

      'started_at'    => date('Y-m-d H:i:s', strtotime($this->started_at)),
      'ended_at'      => date('Y-m-d H:i:s', strtotime($this->ended_at)),
      'registration_end_at' => date('Y-m-d H:i:s', strtotime($this->registration_end_at)),

      'meeting_url' => $this->meeting_url,
      'recording_url' => $this->recording_url,

      // 💰 Pricing
      'actual_price'  => $this->actual_price,
      'discount_price' => $this->discount_price,
      'net_price'     => $this->net_price,

      // 🎥 Webinar Features
      'max_participants' => $this->max_participants,
      'is_record_enabled' => (bool) $this->is_record_enabled,
      'is_chat_enabled'   => (bool) $this->is_chat_enabled,
      'is_screen_share_enabled' => (bool) $this->is_screen_share_enabled,
      'is_whiteboard_enabled'   => (bool) $this->is_whiteboard_enabled,
      'is_camera_enabled'       => (bool) $this->is_camera_enabled,
      'is_audio_only_enabled'   => (bool) $this->is_audio_only_enabled,

      'provider' => $this->provider ? [
        'id' => $this->provider->id,
        'name' => $this->provider->name,
        'slug' => $this->provider->slug,
        'type' => $this->provider->type,
      ] : null,
      'host' => $this->host ? [
        'id' => $this->host->id,
        'name' => $this->host->name,
        'email' => $this->host->email,
      ] : null,
      'registrations_count' => $this->registrations->count(),
      'status' => $classStatus,
            'is_public'     => (bool) $this->is_public,

      'is_enrolled'   => (bool) ($this->is_enrolled ?? false),
      // 'is_enrolled' => $this->whenLoaded('registrations')->count() ? true : false,
    ];
  }
}
