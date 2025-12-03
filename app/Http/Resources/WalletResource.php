<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    protected $wallet_histories;
    protected $wallet;

    public function __construct($wallet = null, $wallet_histories = [])
    {
        parent::__construct($wallet);
        $this->wallet = $wallet;
        $this->wallet_histories = $wallet_histories;
    }

    public function toArray($request)
    {
        return [
            'green' => [
                'balance' => $this->green_balance,
                'target' => 4000, // optional
                'history' => WalletHistoryResource::collection(
                    $this->wallet_histories->where('wallet_type', 'green')
                ),
            ],

            'rupee' => [
                'balance' => $this->rupee_balance,
                'target' => 5000, // optional
                'history' => WalletHistoryResource::collection(
                    $this->wallet_histories->where('wallet_type', 'rupee')
                ),
            ],
        ];
    }
}
