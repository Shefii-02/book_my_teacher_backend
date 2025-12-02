<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->user->name ?? 'Student',
            'avatar' => $this->user->avatar_url ?? 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => $this->comments ?? '',
            'rating' => $this->rating ?? '3.0',
        ];
    }
}
