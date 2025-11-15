<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
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

  public function  userDataRetrieve(Request $request)
  {
    try {
      $user = $request->user();
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


  public function myWallet(): JsonResponse
  {
    return response()->json([
      'green' => [
        'balance' => 780,
        'target' => 1000,
        'history' => [
          ['title' => 'Completed Demo Class', 'type' => 'credit', 'amount' => 50, 'date' => '2025-11-01', 'status' => 'Approved'],
          ['title' => 'Redeemed to Rupees', 'type' => 'debit', 'amount' => 100, 'date' => '2025-10-20', 'status' => 'Processed'],
        ],
      ],
      'rupee' => [
        'balance' => 5400,
        'target' => 5000,
        'history' => [
          ['title' => 'Converted from Coins', 'type' => 'credit', 'amount' => 100, 'date' => '2025-10-20', 'status' => 'Completed'],
          ['title' => 'Transferred to Bank', 'type' => 'debit', 'amount' => 5000, 'date' => '2025-09-25', 'status' => 'Pending'],
        ],
      ],
    ]);
  }

  public function convertToRupees(Request $request)
  {
    // Dummy logic — you can replace this with real DB update
    return response()->json([
      'success' => true,
      'message' => 'Conversion request submitted successfully!',
      'request_id' => rand(1000, 9999),
      'status' => 'pending',
    ]);
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

}
