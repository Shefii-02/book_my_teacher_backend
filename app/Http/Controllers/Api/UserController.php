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
      Log::info('User data retrieved', [
        'user' => (new UserResource($user, $accountMsg, $steps))->toArray(request()),
      ]);


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
}
