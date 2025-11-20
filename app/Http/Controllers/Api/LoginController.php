<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Traits\JsonResponseTrait;
use Exception;
use Google\Service\CloudSourceRepositories\Repo;
use Google_Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
  use AuthorizesRequests, ValidatesRequests, JsonResponseTrait;

  public function userExistNot($mobileNo = null, $company_id = null)
  {
    $user =  User::where('mobile', $mobileNo)->where('company_id', $company_id)->first();
    if ($user) {
      return true;
    } else {
      return false;
    }
  }

  public function googleLoginCheck(Request $request)
  {
    try {

      $user = $request->user();
      Log::info('user: ' . $user);

      $idToken = $request->input('idToken');
      Log::info('idToken: ' . substr($idToken, 0, 50) . '...'); // log partial token for safety

      if (!$idToken) {
        return response()->json([
          'status' => 'error',
          'message' => 'Missing idToken'
        ]);
      }

      // ✅ Verify token using Google API client
      $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
      $payload = $client->verifyIdToken($idToken);

      if (!$payload) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid Google token'
        ]);
      }

      Log::info('Google payload: ' . json_encode($payload, JSON_PRETTY_PRINT));

      $email = $payload['email'] ?? null;

      if (!$email) {
        return response()->json([
          'status' => 'error',
          'message' => 'Email not found in token'
        ]);
      }

      Log::info("Checking user with email: {$email}");

      // ✅ Check if email exists in your users table
      $userEx = User::where('email', $email)->where('company_id', 1)->first();
      Log::info($userEx);
      if ($user) {
        Log::info("User found: {$user->id}");
        $user->email = $email;
        $user->email_verified_at = now();
        $user->save();
        return response()->json([
          'status' => 'success',
          'user' => $user
        ]);
      } else if ($userEx) {
        //login user

        // Revoke all existing tokens
        $userEx->tokens()->delete();

        // Generate token if using Sanctum
        $token = $userEx->createToken('auth_token')->plainTextToken;
        $userEx->email_verified_at = now();
        $userEx->save();
        $userEx->refresh();
        return response()->json([
          'success' => true,
          'message' => 'Login successfully',
          'user'    => $userEx,
          'token'   => $token,
        ], 200);
      } else {
        Log::info("User not found for email: {$email}");
        return response()->json([
          'status' => 'error',
          'message' => 'Account not found. Please sign up normally.',
        ]);
      }
    } catch (\Exception $e) {
      Log::error('Google login check failed: ' . $e->getMessage());
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage(),
      ]);
    }
  }

  public function  userDataRetrieve(Request $request)
  {
    try {
      $user = $request->user();
      return response()->json([
        'success' => true,
        'message' => 'User data fetched successfully',
        'user'    => $user,
        'referral_code' => 'BMT-9834',
      ], 200);
    } catch (Exception $e) {
      Log::error('User data getting  failed: ' . $e->getMessage());
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
      ]);
    }
  }

  public function userVerifyEmail(Request $request)
  {
    try {
      $user = $request->user();
      if ($user->email_verified_at) {
        return response()->json([
          'success' => true,
          'message' => 'Email already verified.',
        ], 200);
      }

      $idToken = $request->input('idToken');
      Log::info('idToken: ' . substr($idToken, 0, 50) . '...'); // log partial token for safety

      if (!$idToken) {
        return response()->json([
          'status' => 'error',
          'message' => 'Missing idToken'
        ]);
      }

      // ✅ Verify token using Google API client
      $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
      $payload = $client->verifyIdToken($idToken);

      if (!$payload) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid Google token'
        ]);
      }

      Log::info('Google payload: ' . json_encode($payload, JSON_PRETTY_PRINT));

      $email = $payload['email'] ?? null;

      if (!$email) {
        return response()->json([
          'status' => 'error',
          'message' => 'Email not found in token'
        ]);
      }


      $user->email = $email;
      $user->email_verified_at = now();

      $user->save();
      Log::error('User email verification successfully: ' . $user->email);
      return response()->json([
        'success' => true,
        'message' => 'User Email Verification successfully',
      ], 200);
    } catch (Exception $e) {
      Log::error('User email verification failed: ' . $e->getMessage());

      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
      ]);
    }
  }
}
