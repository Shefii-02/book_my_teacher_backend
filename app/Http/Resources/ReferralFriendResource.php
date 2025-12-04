<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferralFriendResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name'          => $this->appliedUser->name ?? 'Unknown',
            'joined_at'     => optional($this->appliedUser->created_at)->format('Y-m-d'),
            'earned_coins'  => 100,
            'status'        => $this->status,
        ];
    }
}
