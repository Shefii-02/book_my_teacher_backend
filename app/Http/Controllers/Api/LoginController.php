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
      Log::info('idToken :' . $idToken);



      if (!$idToken) {
        Log::info(1);
        return response()->json(['status' => 'error', 'message' => 'Missing idToken']);
      }
      Log::info('--------------');
      // ✅ Verify token using Google API client
      $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
      $payload = $client->verifyIdToken($idToken);

      if (!$payload) {
        return response()->json(['status' => 'error', 'message' => 'Invalid Google token']);
      }

      Log::info('payload:' . $payload);

      $email = $payload['email'] ?? null;

      if (!$email) {
        return response()->json(['status' => 'error', 'message' => 'Email not found in token']);
      }

      Log::info($email);

      // ✅ Check if email exists in your users table
      $user = \App\Models\User::where('email', $email)->first();
      Log::info('user' . $user);

      if ($user) {
        return response()->json(['status' => 'success', 'user' => $user]);
      } else {
        return response()->json([
          'status' => 'error',
          'message' => 'Account not found. Please sign up normally.',
        ]);
      }
    } catch (Exception $e) {
      Log::info($e);
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage(),
      ]);
    }
  }
}
