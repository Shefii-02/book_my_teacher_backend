<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class AppReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => (int)$this->id,

            'name'    => $this->user?->name ?? 'Anonymous',

            'review'  => $this->feedback,

            'image'   => $this->user?->avatar_url
                         ?? 'https://i.pravatar.cc/150?img=5',

            'rating'  => (float)$this->rating,

            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}
