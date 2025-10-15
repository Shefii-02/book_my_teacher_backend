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
      $user = \App\Models\User::where('email', $email)->first();

      if ($user) {
        Log::info("User found: {$user->id}");
        return response()->json([
          'status' => 'success',
          'user' => $user
        ]);
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
}
