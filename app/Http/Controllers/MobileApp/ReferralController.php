<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\AppReferral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
  /**
   * Show referral summary for a user
   */
  public function index(Request $request)
  {
    $search = $request->search;
// $users = AppReferral::query()
//     ->leftJoin('users', 'app_referrals.ref_user_id', '=', 'users.id')

//     ->when($search, function ($q) use ($search) {
//         $q->where(function ($inner) use ($search) {
//             $inner->where('users.name', 'LIKE', "%{$search}%")
//                 ->orWhere('users.email', 'LIKE', "%{$search}%")
//                 ->orWhere('users.mobile', 'LIKE', "%{$search}%")
//                 ->orWhere('users.referral_code', 'LIKE', "%{$search}%");
//         });
//     })

//     ->groupBy('app_referrals.ref_user_id')

//     ->select([
//         'app_referrals.ref_user_id as id',

//         DB::raw("COALESCE(users.name, 'Deleted User') as name"),
//         'users.email',
//         'users.mobile',
//         'users.referral_code',

//         DB::raw('COUNT(app_referrals.id) as total_visits'),
//         DB::raw('SUM(app_referrals.applied = 1) as joined_users'),
//     ])

//     ->paginate(20);

    $users = AppReferral::with('user')
    ->when($search, function ($q) use ($search) {
        $q->whereHas('user', function ($u) use ($search) {
            $u->where('name', 'LIKE', "%$search%")
              ->orWhere('email', 'LIKE', "%$search%")
              ->orWhere('mobile', 'LIKE', "%$search%")
              ->orWhere('referral_code', 'LIKE', "%$search%");
        });
    })
    ->select(
        'ref_user_id',
        DB::raw('COUNT(id) as total_visits'),
        DB::raw('SUM(applied = 1) as joined_users')
    )
    ->groupBy('ref_user_id')
    ->paginate(20);


    return view('company.mobile-app.referrals.index', compact('users'));
  }


  /**
   * View referral details for a specific user's referral_code
   */
  public function show($userId)
  {
    $user = User::findOrFail($userId);

    $referrals = AppReferral::with('appliedUser')
      ->where('ref_user_id', $user->id)
      ->orderBy('id', 'desc')
      ->paginate(25);

    $joinedCount = $referrals->where('applied', 1)->count();
    $totalVisitors = $referrals->count();

    return view('company.mobile-app.referrals.show', compact('user', 'referrals', 'joinedCount', 'totalVisitors'));
  }


  public function pointApprove($ref_id){
    dd($ref_id);
  }
}
