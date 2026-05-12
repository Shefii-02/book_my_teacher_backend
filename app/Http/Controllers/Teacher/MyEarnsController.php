<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\TeacherEarning;
use App\Models\TeacherPaymentTransfer;
use Carbon\Carbon;

class MyEarnsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Earnings
        |--------------------------------------------------------------------------
        */
        $earns = TeacherEarning::where('teacher_id', $user->id)
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Transfers
        |--------------------------------------------------------------------------
        */
        $transfers = TeacherPaymentTransfer::where('teacher_id', $user->id)
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Stats
        |--------------------------------------------------------------------------
        */

        $data['total_earnings'] = $earns
            ->where('status', 'completed')
            ->sum('amount');

        $data['this_month_earnings'] = $earns
            ->where('status', 'completed')
            ->filter(function ($item) {
                return Carbon::parse($item->earned_at)->isCurrentMonth();
            })
            ->sum('amount');

        $data['today_earnings'] = $earns
            ->where('status', 'completed')
            ->filter(function ($item) {
                return Carbon::parse($item->earned_at)->isToday();
            })
            ->sum('amount');

        $data['total_payout'] = $transfers
            ->where('status', 'completed')
            ->sum('final_amount');

        $data['pending_payout'] = $transfers
            ->whereIn('status', ['pending', 'processing'])
            ->sum('final_amount');

        $data['available_balance'] =
            $data['total_earnings'] -
            ($data['total_payout'] + $data['pending_payout']);

        return view(
            'teacher.my_earns.index',
            compact(
                'earns',
                'transfers',
                'data'
            )
        );
    }
}
