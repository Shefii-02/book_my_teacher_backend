<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AppReferral;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
  public function trackReferral(Request $request)
  {
    $ip = $request->ip();
    $ua = strtolower($request->header('User-Agent', 'unknown'));

    // Unique device fingerprint
    $deviceHash = hash('sha256', $ip . $ua);

    $code = $request->ref; // referral code from URL

    // Check if this device visited before
    $existing = AppReferral::where('device_hash', $deviceHash)->first();

    if ($existing) {
      // Update only last_visit and referral code (if changed)
      $existing->update([
        'referral_code' => $code,
        'last_visit'    => Carbon::now(),
        'ip'            => $ip,
        'ua'            => $ua,
      ]);

      $ref = $existing;
    } else {
      // Create new record
      $ref = AppReferral::create([
        'referral_code' => $code,
        'device_hash'   => $deviceHash,
        'ip'            => $ip,
        'ua'            => $ua,
        'first_visit'   => Carbon::now(),
        'last_visit'    => Carbon::now(),
        'applied'       => false,
        'status'        => 'active',
      ]);
    }

    // Detect device type for redirect
    if (strpos($ua, 'android') !== false) {
      return redirect("https://play.google.com/store/apps/details?id=coin.bookmyteacher.app&ref_code={$code}");
    }

    if (strpos($ua, 'iphone') !== false || strpos($ua, 'ipad') !== false) {
      return redirect("https://apps.apple.com/app/id1234567890?ref_code={$code}");
    }

    // Desktop or unknown → redirect to website / Play Store
    return redirect("https://play.google.com/store/apps/details?id=coin.bookmyteacher.app&ref_code={$code}");
  }


  public function takeReferral(Request $request)
  {
    $ip = $request->ip();
    $ua = strtolower($request->header('User-Agent', 'unknown'));

    // Unique device fingerprint
    $deviceHash = hash('sha256', $ip . $ua);
    Log::info($deviceHash);
    // Check if this device visited before
    $existing = AppReferral::where('ip', $ip)->first();
    Log::info($existing);
    if ($existing) {
      $referral_code = $existing->referral_code;
    } else {
      $referral_code = '';
    }

    return response()->json([
      'success' => true,
      'code'    => $referral_code,
    ], 200);
  }


  public function applyReferral(Request $request)
  {
    $user = $request->user();

    $request->validate([
      'referral_code' => 'required|string',
    ]);

    $ip = $request->ip();
    $ua = strtolower($request->header('User-Agent'));

    // Create a unique device fingerprint
    $deviceHash = hash('sha256', $ip . $ua);

    $user_id = $user->id;
    $code = $request->referral_code;

    // Find last matching referral visit
    $ref = AppReferral::where('referral_code', $code)->where('ip', $ip)
      // ->where('applied', false)
      ->orderBy('first_visit', 'desc')
      ->first();

    Log::info($ref);

    if (!$ref) {
      return response()->json([
        'status' => false,
        'message' => 'Invalid or already used referral code'
      ], 400);
    }

    // Mark applied
    $ref->update([
      'applied' => true,
      'applied_user_id' => $user_id,
      // 'ref_user_id' => User::where('referral_code', $code)->value('id'),
      'ref_user_id' => 1,
      'last_visit' => now(),
    ]);

    Log::info($ref);

    // TODO: Give rewards to both users here

    return response()->json([
      'status' => true,
      'message' => "Referral applied successfully",
      'data' => $ref
    ]);
  }
}
