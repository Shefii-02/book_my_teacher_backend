<?php

namespace App\Http\Controllers\LMS\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseInstallment;
use App\Models\StudentCourse;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefferalRewardAnalyticsController extends Controller
{
  public function index(Request $request)
  {
    $query = WalletHistory::with('user')->latest();

    if ($request->from && $request->to) {
      $query->whereBetween('created_at', [
        $request->from . ' 00:00:00',
        $request->to . ' 23:59:59'
      ]);
    }

    if ($request->search) {
      $query->whereHas('user', function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%")
          ->orWhere('email', 'like', "%{$request->search}%")
          ->orWhere('mobile', 'like', "%{$request->search}%");
      });
    }

    $referrals = $query->paginate(15)->withQueryString();

    return view('company.analytics.referrals', compact('referrals'));
  }
}
