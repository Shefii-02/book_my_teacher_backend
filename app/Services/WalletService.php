<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletService
{
    // Get wallet by user + type
    public function getWallet($userId, $type)
    {
        return Wallet::firstOrCreate(
            ['user_id' => $userId, 'type' => $type],
            ['balance' => 0, 'target' => 0]
        );
    }

    // Add green coin
    public function addGreenCoins($userId, $amount, $title = "Green Coins Earned")
    {
        $wallet = $this->getWallet($userId, "green");

        $wallet->balance += $amount;
        $wallet->save();

        // Add transaction
        $wallet->transactions()->create([
            'title' => $title,
            'type' => 'credit',
            'amount' => $amount,
            'status' => 'Approved',
            'date' => now()->format("Y-m-d")
        ]);

        return $wallet;
    }

    // Deduct green coin
    public function deductGreenCoins($userId, $amount, $title = "Green Coins Deducted")
    {
        $wallet = $this->getWallet($userId, "green");

        if ($wallet->balance < $amount) {
            return false; // Insufficient balance
        }

        $wallet->balance -= $amount;
        $wallet->save();

        // Add transaction
        $wallet->transactions()->create([
            'title' => $title,
            'type' => 'debit',
            'amount' => $amount,
            'status' => 'Completed',
            'date' => now()->format("Y-m-d")
        ]);

        return $wallet;
    }

    // Add rupee
    public function addRupees($userId, $amount, $title = "Amount Credited")
    {
        $wallet = $this->getWallet($userId, "rupee");

        $wallet->balance += $amount;
        $wallet->save();

        $wallet->transactions()->create([
            'title' => $title,
            'type' => 'credit',
            'amount' => $amount,
            'status' => 'Completed',
            'date' => now()->format("Y-m-d")
        ]);

        return $wallet;
    }

    // Deduct rupees (withdraw)
    public function deductRupees($userId, $amount, $title = "Debited to Bank")
    {
        $wallet = $this->getWallet($userId, "rupee");

        if ($wallet->balance < $amount) {
            return false;
        }

        $wallet->balance -= $amount;
        $wallet->save();

        $wallet->transactions()->create([
            'title' => $title,
            'type' => 'debit',
            'amount' => $amount,
            'status' => 'Pending',
            'date' => now()->format("Y-m-d")
        ]);

        return $wallet;
    }

    // Green Coins → Rupee Conversion
    public function convertGreenToRupee($userId, $greenAmount, $rate = 1)
    {
        // Example: 10 green coins = 1 rupee
        $rupeeAmount = $greenAmount * $rate;

        // Deduct green coins first
        $deduct = $this->deductGreenCoins(
            $userId,
            $greenAmount,
            "Converted to Rupees"
        );

        if (!$deduct) {
            return false;
        }

        // Add rupees second
        $this->addRupees(
            $userId,
            $rupeeAmount,
            "Converted from Green Coins"
        );

        return [
            'green_deducted' => $greenAmount,
            'rupees_added'   => $rupeeAmount
        ];
    }
}
