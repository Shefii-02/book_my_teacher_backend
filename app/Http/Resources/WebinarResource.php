<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebinarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'is_public' => (bool) $this->is_public,
            'thumbnail_url' => $this->thumbnail_image ? asset('storage/' . $this->thumbnail_image) : null,
            'main_image_url' => $this->main_image ? asset('storage/' . $this->main_image) : null,
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
            'start_time' => $this->started_at,
            'end_time' => $this->ended_at,
            'registration_end_at' => $this->registration_end_at,
            'meeting_url' => $this->meeting_url,
            'recording_url' => $this->recording_url,
            'meta' => $this->meta ? json_decode($this->meta, true) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
