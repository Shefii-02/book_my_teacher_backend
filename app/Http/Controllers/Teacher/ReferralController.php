<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Referral Data
        |--------------------------------------------------------------------------
        | Assumption:
        | wallet_histories table stores referral coin entries
        | title contains "Referral"
        |--------------------------------------------------------------------------
        */

        $referrals = DB::table('wallet_histories')
            ->where('user_id', $teacherId)
            ->where('wallet_type', 'green')
            ->where(function ($q) {
                $q->where('title', 'LIKE', '%Referral%')
                    ->orWhere('notes', 'LIKE', '%Referral%');
            })
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $data = [];

        $data['total_referrals'] = $referrals->count();

        $data['total_coins'] = $referrals
            ->where('type', 'credit')
            ->sum('amount');

        $data['pending_coins'] = $referrals
            ->where('status', 'pending')
            ->sum('amount');

        $data['approved_coins'] = $referrals
            ->where('status', 'approved')
            ->sum('amount');

        return view(
            'teacher.referral.index',
            compact('data', 'referrals')
        );
    }
}
