<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeacher;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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
    $token = $request->input('token');

    if (!$token) {
      return response()->json([
        'status' => 'error',
        'message' => 'Token is required'
      ], 400);
    }

    $user = User::where('api_token', $token)->first();

    if (!$user) {
      return response()->json([
        'status' => 'error',
        'message' => 'User not found'
      ], 404);
    }

    return response()->json([
      'status' => 'success',
      'data' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'acc_type' => $user->acc_type,
        'profile_fill' => $user->profile_fill,
      ]
    ], 200);
  }

  // Set or update user token
  public function setUserToken(Request $request)
  {
    $userId = $request->input('user_id');

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

    $user->api_token = bin2hex(random_bytes(30)); // generate new token
    $user->save();

    return response()->json([
      'status' => 'success',
      'token' => $user->api_token,
    ], 200);
  }
}
