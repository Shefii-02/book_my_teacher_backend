<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReferralFriendResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use App\Models\AppReferral;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $mobileNo   = '91' . $request->mobile;
    $company_id = 1;

    $user = User::where('mobile', $mobileNo)
      ->where('company_id', $company_id)
      ->first();

    if ($user) {
      return response()->json([
        'success' => true,
        'message' => 'User details found successfully',
        'data'    => $user,
      ], 200);
    }

    return response()->json([
      'success' => false,
      'message' => 'User details not found',
      'data'    => null,
    ], 404);
  }

  public function overviewTeacher($id)
  {
    $teacher = User::with([
      'professionalInfo',
      'workingDays',
      'workingHours',
      'teacherGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'teacher')->first();

    if (!$teacher) {
      return response()->json(['message' => 'Teacher not found'], 404);
    }

    return response()->json($teacher, 200);
  }


  // Fetch user data by token
  public function getUserDetails(Request $request)
  {

    // Log::info($request->header());
    //     Log::info($request->all());
    // $token = $request->input('token');

    // if (!$token) {
    //   return response()->json([
    //     'status' => 'error',
    //     'message' => 'Token is required'
    //   ], 400);
    // }

    $user = $request->user();

    // Log::info($user);

    if (!$user) {
      return response()->json([
        'status' => 'error',
        'message' => 'User not found'
      ], 404);
    }

    return response()->json([
      'status' => 'success',
      'data' => $user,
    ], 200);
  }

  // Set or update user token
  public function setUserToken(Request $request)
  {
    $userId = $request->input('user_id');
    $company_id = 1;

    if (!$userId) {
      return response()->json([
        'status' => 'error',
        'message' => 'User ID is required'
      ], 400);
    }

    $user = User::find($userId);

    if (!$user) {
      return response()->json([
        'status' => 'error',
        'message' => 'User not found'
      ], 404);
    }

    $token = $user->createToken('MyAppToken')->plainTextToken;

    return response()->json([
      'status' => 'success',
      'data'   => $user,
      'token' => $token,
    ], 200);
  }

  public function checkServer(): JsonResponse
  {
    try {
      // Example: You could load status from .env or database
      $status = config('app.status', 'production');
      // Or from env: env('APP_STATUS', 'production')

      // You can also add server health check logic here
      // Example: check DB connection
      try {
        DB::connection()->getPdo();
        $db_status = "ok";
      } catch (\Exception $e) {
        $db_status = "failed";
      }

      return response()->json([
        'status' => $status, // "production" or "development"
        'db_status' => $db_status,
        'message' => $status === 'development'
          ? 'App under maintenance'
          : 'Server running fine',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => 'Server check failed',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  public function userLogout(Request $request)
  {
    $user = $request->user();
    Log::info($user);
    Log::info("Logouted");
    return response()->json([
      'success' => true,
      'message' => 'Logout successfully'
    ], 200);
  }
  public function deleteAccountRequest(Request $request)
  {
    $user = $request->user();
    Log::info($user);
    Log::info("Delete Account Request Received");
    return response()->json([
      'success' => true,
      'message' => 'Account Deletion Request Received'
    ], 200);
  }

  public function  userDataRetrieve(Request $request)
  {
    try {
      $user = $request->user();
      if (!$user) {
        Log::info("user founded");
      }
      $accountStatusResponse = accountStatus($user);
      $accountMsg = $accountStatusResponse['accountMsg'];
      $steps = $accountStatusResponse['steps'];
      // Log::info('User data retrieved', [
      //   'user' => (new UserResource($user, $accountMsg, $steps))->toArray(request()),
      // ]);

      return response()->json([
        'success' => true,
        'message' => 'User data fetched successfully',
        'user'              => new UserResource($user, $accountMsg, $steps),
      ], 200);
    } catch (Exception $e) {
      Log::error('User data getting  failed: ' . $e->getMessage());
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
      ]);
    }
  }



  public function myWallet2(Request $request): JsonResponse
  {
    // $user = $request->user();
    $wallet =  Wallet::where('user_id', 1)->first();
    $wallet_histories = WalletHistory::where('user_id', 1)->get();
    return response()->json(new WalletResource($wallet, $wallet_histories));
  }

  public function myWallet(Request $request): JsonResponse
  {
    $user = $request->user();
    $wallet =  Wallet::where('user_id', $user->id)->first();
    $wallet_histories = WalletHistory::where('user_id', $user->id)->get();
    return response()->json(new WalletResource($wallet, $wallet_histories));



    // return response()->json([
    //   'green' => [
    //     'balance' => 780,
    //     'target' => 1000,
    //     'history' => [
    //       ['title' => 'Completed Demo Class', 'type' => 'credit', 'amount' => 50, 'date' => '2025-11-01', 'status' => 'Approved'],
    //       ['title' => 'Redeemed to Rupees', 'type' => 'debit', 'amount' => 100, 'date' => '2025-10-20', 'status' => 'Processed'],
    //     ],
    //   ],
    //   'rupee' => [
    //     'balance' => 4400,
    //     'target' => 5000,
    //     'history' => [
    //       ['title' => 'Converted from Coins', 'type' => 'credit', 'amount' => 100, 'date' => '2025-10-20', 'status' => 'Completed'],
    //       ['title' => 'Transferred to Bank', 'type' => 'debit', 'amount' => 5000, 'date' => '2025-09-25', 'status' => 'Pending'],
    //     ],
    //   ],
    // ]);
  }

  public function convertToRupees(Request $request)
  {
    DB::beginTransaction();
    $user = $request->user();
    $wallet = Wallet::where('user_id', $user->id)->first();
    $greenCoinValue = 0.01;
    try {
      if ($wallet->green_balance > 4000) {
        $history                = new WalletHistory();
        $history->user_id       = $user->id;
        $history->wallet_type   = 'green';
        $history->title         = "Converted to Rupees";
        $history->type          = "debit";
        $history->amount        = $request->amount;
        $history->status        = "Processed";
        $history->date          = now();
        $history->notes         = "Converted green coins to rupees";
        $history->save();

        $wallet->green_balance = $wallet->green_balance - $request->amount;
        $wallet->rupee_balance = $wallet->rupee_balance + ($greenCoinValue * $request->amount);
        $wallet->save();

        $history                = new WalletHistory();
        $history->user_id       = $user->id;
        $history->wallet_type   = 'rupee';
        $history->title         = "Converted to Rupees";
        $history->type          = "credit";
        $history->amount        = $greenCoinValue * $request->amount;
        $history->status        = "Processed";
        $history->date          = now();
        $history->notes         = "Converted green coins to rupees";
        $history->save();

        DB::commit();

        return response()->json([
          'success' => true,
          'message' => 'Conversion request submitted successfully!',
          'request_id' => date('Ymd', strtotime($history->date)),
          'status' => 'Processed',
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'success' => false,
          'message' => 'Conversion request submitted failed!',
          'request_id' => date('Ymd', strtotime(now())),
          'status' => 'Processed',
        ]);
      }
    } catch (Exception $e) {
      Log::info($e);
      DB::rollBack();
      return response()->json([
        'success' => false,
        'message' => 'Conversion request submitted failed!',
        'request_id' => date('Ymd', strtotime(now())),
        'status' => 'Processed',
      ]);
    }
  }

  public function transferToBank(Request $request)
  {
    Log::info('👨‍🏫 Transfer to Bank Account:', $request->all());

    return response()->json([
      'success' => true,
      'message' => 'Transfer request submitted successfully!',
      'transaction_id' => rand(10000, 99999),
      'status' => 'pending',
    ]);
  }

  public function Referral(): JsonResponse
  {
    return response()->json([
      'referral_link' => 'https://bookmyteacher.com/ref/ABC123',
      'qr_code_url' => 'https://cdn.app/qr/ABC123.png',
      'bonus_threshold' => 5,
      'expiry_date' => now()->addMonths(2)->toDateString(),
      'my_referral_list' => [
        ['name' => 'Ankit', 'joined_at' => '2025-09-12'],
        ['name' => 'Riya', 'joined_at' => '2025-09-18']
      ],
      'referral_terms_points' => [
        ['category' => 'signup', 'points' => 10],
        ['category' => 'review', 'points' => 5]
      ],
      'reward_per_referral' => 20
    ]);
  }


  public function referralStats(Request $request): JsonResponse
  {
    $user = $request->user();
    $walletHistory =  WalletHistory::where('user_id', $user->id)->get();
    $reward_per_join = 100;
    $bonus_on_first_class = 250;
    $earned_coins = $walletHistory->where('wallet_type', 'green')->where('type', 'credit')->sum('amount');
    $joinedUsers = AppReferral::with('appliedUser')->where('ref_user_id', $user->id)->get();
    $friends_joined = $joinedUsers->where('status', 'active')->count();

    $user = $request->user();

    // Calculate Earned Coins
    $earned_coins = $walletHistory
      ->where('wallet_type', 'green')
      ->where('type', 'credit')
      ->sum('amount');

    // All Joined Users via referral
    $joinedUsers = AppReferral::with('appliedUser')
      ->where('ref_user_id', $user->id)
      ->get();

    // Only Completed/Active Joins
    $friends_joined = $joinedUsers->where('status', 'active')->count();

    return response()->json([
      'referral_code' => $user->referral_code,
      'earned_coins' => $earned_coins,
      'friends_joined' => $friends_joined,
      'reward_per_join' => $reward_per_join,
      'bonus_on_first_class' => $bonus_on_first_class,

      'how_it_works' => 'How it works',
      'how_it_works_description' =>
      'For each friend who joins using your link/code, you earn Green Coins. Coins can be converted to rewards or wallet credits.',

      'badge_title' => '💰 Earn Green Coins',
      'badge_description' =>
      "• $reward_per_join coins when your friend joins\n" .
        "• $bonus_on_first_class extra coins when they join first class\n" .
        "• Track your invites in Rewards → Invited List",

      'share_link_description' =>
      "Join me on BookMyTeacher! Use my referral code {$user->referral_code} to sign up and earn rewards. " .
        "https://bookmyteacher.cloud/invite?ref={$user->referral_code}",

      // RESOURCE BASED FRIEND LIST
      'friends_list' => ReferralFriendResource::collection($joinedUsers),
    ]);


    // return response()->json([
    //   'referral_code' => $user->referral_code,
    //   'earned_coins' => $earned_coins,
    //   'friends_joined' => $friends_joined,
    //   'reward_per_join' => $reward_per_join,
    //   'bonus_on_first_class' => $bonus_on_first_class,
    //   'how_it_works' => 'How it works',
    //   'how_it_works_description' => 'For each friend who joins using your link/code, you earn Green Coins. Coins can be converted to rewards or wallet credits.',
    //   'badge_title' => '💰 Earn Green Coins',
    //   'badge_description' => "• $reward_per_join coins when your friend joins\n• $bonus_on_first_class extra coins when they join first class\n• Track your invites in Rewards → Invited List",
    //   'share_link_description' => 'Join me on BookMyTeacher! Use my referral code BMT-9834 to sign up and earn rewards.https://bookmyteacher.cloud/invite?ref=BMT-9834',
    //   'friends_list' => [
    //     //resource connect(joinedUsers)
    //     [
    //       'name' => 'Rahul Mehta',
    //       'joined_at' => '2025-10-30',
    //       'earned_coins' => 150,
    //       'status' => 'completed',
    //     ],
    //     [
    //       'name' => 'Anjali Singh',
    //       'joined_at' => '2025-10-27',
    //       'earned_coins' => 100,
    //       'status' => 'joined',
    //     ],
    //     [
    //       'name' => 'Vikas Kumar',
    //       'joined_at' => '2025-10-25',
    //       'earned_coins' => 0,
    //       'status' => 'pending',
    //     ],
    //     [
    //       'name' => 'Priya Sharma',
    //       'joined_at' => '2025-10-21',
    //       'earned_coins' => 50,
    //       'status' => 'joined',
    //     ],
    //     [
    //       'name' => 'Vikas Kumar',
    //       'joined_at' => '2025-10-25',
    //       'earned_coins' => 0,
    //       'status' => 'pending',
    //     ],
    //   ],
    // ]);
  }
}
