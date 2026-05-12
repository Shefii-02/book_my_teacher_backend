<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherEarning;
use App\Models\TeacherPaymentTransfer;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | WALLET SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalEarned = TeacherEarning::where('teacher_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $totalTransferred = TeacherPaymentTransfer::where('teacher_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        $pendingPayout = TeacherPaymentTransfer::where('teacher_id', $user->id)
            ->whereIn('status', ['pending', 'processing'])
            ->sum('amount');

        $availableBalance = $totalEarned - $totalTransferred - $pendingPayout;

        /*
        |--------------------------------------------------------------------------
        | EARNINGS
        |--------------------------------------------------------------------------
        */

        $earnings = TeacherEarning::with(['creator'])
            ->where('teacher_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) {

                return [
                    'wallet_type' => 'earning',
                    'title' => $item->title ?? 'Teacher Earning',
                    'type' => $item->type,
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'verified_at' => $item->earned_at,
                    'approved_by' => $item->creator?->name ?? 'System',
                    'remarks' => $item->remarks,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | PAYOUTS
        |--------------------------------------------------------------------------
        */

        $payouts = TeacherPaymentTransfer::with(['approver'])
            ->where('teacher_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($item) {

                return [
                    'wallet_type' => 'payout',
                    'title' => $item->transfer_no,
                    'type' => $item->transfer_method,
                    'amount' => $item->amount,
                    'status' => $item->status,
                    'created_at' => $item->requested_at,
                    'verified_at' => $item->processed_at,
                    'approved_by' => $item->approver?->name ?? '-',
                    'remarks' => $item->remarks,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | MERGE HISTORY
        |--------------------------------------------------------------------------
        */

        $wallets = collect()
            ->merge($earnings)
            ->merge($payouts)
            ->sortByDesc('created_at')
            ->values();

        $data = [
            'available_balance' => $availableBalance,
            'total_earned' => $totalEarned,
            'total_transferred' => $totalTransferred,
            'pending_payout' => $pendingPayout,
        ];

        return view(
            'teacher.my_wallet.index',
            compact('data', 'wallets')
        );
    }
}
