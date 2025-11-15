<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AppReferral;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReferralController extends Controller
{
  public function trackReferral(Request $request)
  {
    $ip = $request->ip();
    $ua = strtolower($request->header('User-Agent'));

    // Create a unique device fingerprint
    $deviceHash = hash('sha256', $ip . $ua);

    $code = $request->ref;

    // Save tracking info
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

    // Redirect logic
    if (strpos($ua, 'android') !== false) {
      return redirect("https://play.google.com/store/apps/details?id=com.bookmyteacher.app&ref_code=$code");
    }

    if (strpos($ua, 'iphone') !== false || strpos($ua, 'ipad') !== false) {
      return redirect("https://apps.apple.com/app/id1234567890?ref_code=$code");
    }

    // Desktop → Open website
    return redirect("https://bookmyteacher.com?ref_code=$code");
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
    $ref = AppReferral::where('referral_code', $code)->where('device_hash',$deviceHash)
      ->where('applied', false)
      ->orderBy('first_visit', 'desc')
      ->first();

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
      'ref_user_id' => User::where('referral_code', $code)->value('id'),
      'last_visit' => now(),
    ]);

    // TODO: Give rewards to both users here

    return response()->json([
      'status' => true,
      'message' => "Referral applied successfully",
      'data' => $ref
    ]);
  }
}
