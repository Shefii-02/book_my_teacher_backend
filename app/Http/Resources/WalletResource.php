<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'teacher_id'        => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,

            'wallet' => [
                'green_balance' => $this->wallet->green_balance ?? 0,
                'rupee_balance' => $this->wallet->rupee_balance ?? 0,
            ],

            'wallet_histories'  => WalletHistoryResource::collection($this->walletHistories),
        ];
    }
}
