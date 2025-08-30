<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Traits\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Response;

class OtpController extends Controller
{
  use JsonResponseTrait;

  /**
   * Send OTP for Sign In
   */
  public function sendOtpSignIn(Request $request)
  {
    $request->validate([
      'mobile' => 'required|digits:10',
    ]);

    $company_id = 1;
    $mobile = '91' . $request->mobile; // ✅ correct concatenation

    // check user exists
    if (!$this->userExistNot($mobile, $company_id)) {
      return $this->error('User not found', Response::HTTP_NOT_FOUND);
    }

    $otp = rand(1000, 9999);
    $expTime = 20;

    // Save OTP in DB
    Otp::create([
      'mobile'     => $mobile,
      'otp'        => $otp,
      'expires_at' => Carbon::now()->addMinutes($expTime),
      'company_id' => $company_id,
      'type'       => 'mobile',
      'attempt'    => 1
    ]);

    $response = $this->SmsApiFunction($mobile, $otp, $expTime);

    if ($response && $response->successful()) {
      return $this->success('OTP sent successfully', ['mobile' => $mobile]);
    } else if (!env('SMSOTP', false)) {
      return $this->success('OTP sent successfully', ['mobile' => $mobile]);
    }

    return $this->error('Failed to send OTP', Response::HTTP_BAD_REQUEST);
  }

  /**
   * Send OTP for Sign Up
   */
  public function sendOtpSignUp(Request $request)
  {
    $request->validate([
      'mobile' => 'required|digits:10',
    ]);

    $company_id = 1;
    $mobile = '91' . $request->mobile;

    $otp = rand(1000, 9999);
    $expTime = 20;
    $userr =  User::where('mobile', $mobile)->where('company_id', $company_id)->where('profile_fill', 1)->exists();

    // user already exists? → stop signup
    if ($userr) {
      return $this->error('User already registered', Response::HTTP_CONFLICT);
    }

    // Save OTP
    Otp::create([
      'mobile'     => $mobile,
      'otp'        => $otp,
      'expires_at' => Carbon::now()->addMinutes($expTime),
      'company_id' => $company_id,
      'type'       => 'mobile',
      'attempt'    => 1
    ]);

    $response = $this->SmsApiFunction($mobile, $otp, $expTime);

    if ($response && $response->successful()) {
      return $this->success('OTP sent successfully', ['mobile' => $mobile]);
    } else if (!env('SMSOTP', true)) {
      return $this->success('OTP sent successfully', ['mobile' => $mobile]);
    }

    return $this->error('Failed to send OTP', Response::HTTP_BAD_REQUEST);
  }

  /**
   * Verify OTP for Sign In
   */
  public function verifyOtpSignIn(Request $request)
  {
    $request->validate([
      'mobile' => 'required',
      'otp'    => 'required',
    ]);

    $mobile = '91' . $request->mobile;
    $otpInput = $request->otp;

    $otpRecord = Otp::where('mobile', $mobile)
      ->where('otp', $otpInput)
      ->where('verified', 0)
      ->where('expires_at', '>=', now())
      ->latest()
      ->first();

    if (!$otpRecord) {
      return $this->error('Invalid or expired OTP', Response::HTTP_UNAUTHORIZED);
    }

    User::where('mobile', $mobile)->where('company_id', 1)->update(['mobile_verified' => 1]);


    $otpRecord->update(['verified' => true]);

    $user = User::where('mobile', $mobile)->where('company_id', 1)->first();

    if (!$user) {
      $user = new User();
      $user->mobile          = $mobile;
      $user->mobile_verified = true;
      $user->company_id      = 1;
      $user->profile_fill    = 0;
      $user->save();
    } else {
      $user->update(['mobile_verified' => true]);
    }

    // return $this->success('OTP verified successfully');
    return response()->json([
      'success' => true,
      'message' => 'OTP verified successfully',
      'user'    => $user,
    ], 200);
  }

  /**
   * Verify OTP for Sign Up
   */
  public function verifyOtpSignUp(Request $request)
  {
    $request->validate([
      'mobile' => 'required',
      'otp'    => 'required',
    ]);
    Log::info($request->all());
    $mobile = '91' . $request->mobile;
    $otpInput  = $request->otp;
    $company_id = 1;

    $otpRecord = Otp::where('mobile', $mobile)
      ->where('otp', $otpInput)
      ->where('verified', 0)
      ->where('expires_at', '>=', now())
      ->latest()
      ->first();

    if (!$otpRecord) {
      return $this->error('Invalid or expired OTP', Response::HTTP_UNAUTHORIZED);
    }

    $otpRecord->update(['verified' => true]);

    $user = new User();
    $user->mobile          = $mobile;
    $user->mobile_verified = true;
    $user->company_id      = $company_id;
    $user->profile_fill    = 0;
    $user->save();

    return $this->success('OTP verified successfully');
  }

  /**
   * Send OTP via Email
   */
  public function sendEmailOtp(Request $request)
  {
    $request->validate([
      'email' => 'required|email'
    ]);

    $email      = $request->email;
    $company_id = 1;
    $otp        = rand(1000, 9999);
    $expTime    = 20;

    Otp::create([
      'mobile'     => $email, // ⚠️ could rename to 'email' in DB for clarity
      'otp'        => $otp,
      'expires_at' => Carbon::now()->addMinutes($expTime),
      'company_id' => $company_id,
      'type'       => 'email'
    ]);

    try {
      Mail::to($email)->send(new SendOtpMail($otp, $expTime));
      return $this->success('OTP sent successfully', ['email' => $email]);
    } catch (\Exception $e) {
      Log::error("Email OTP failed: " . $e->getMessage());
      return $this->error('Failed to send OTP: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
    }
  }

  /**
   * Verify Email OTP
   */
  public function verifyEmailOtp(Request $request)
  {
    $request->validate([
      'email' => 'required',
      'otp'   => 'required',
    ]);

    $email    = $request->email;
    $otpInput = $request->otp;

    $otpRecord = Otp::where('mobile', $email)
      ->where('otp', $otpInput)
      ->where('verified', 0)
      ->where('expires_at', '>=', now())
      ->where('type', 'email')
      ->latest()
      ->first();

    if (!$otpRecord) {
      return $this->error('Invalid or expired OTP', Response::HTTP_UNAUTHORIZED);
    }

    $otpRecord->update(['verified' => true]);
    User::where('email', $email)->where('company_id', 1)->update(['email_verified_at' => date('Y-m-d H:i:s')]);

    return $this->success('OTP verified successfully');
  }

  /**
   * Reusable SMS Function
   */
  private function SmsApiFunction($mobile = null, $otp = null, $expTime = 20)
  {
    if ($mobile && $otp && env('SMSOTP', true)) {
      return Http::get("https://www.smsgatewayhub.com/api/mt/SendSMS", [
        'APIKey'        => config('services.smsgatewayhub.key'),
        'senderid'      => config('services.smsgatewayhub.senderid'),
        'channel'       => 2,
        'DCS'           => 0,
        'flashsms'      => 0,
        'number'        => $mobile,
        'text'          => "{$otp} is your One Time Password (OTP) for login/signup at BookMyTeacher. Valid for {$expTime} minutes. Do not share it with anyone.",
        'route'         => 54,
        'EntityId'      => config('services.smsgatewayhub.entity_id'),
        'dlttemplateid' => config('services.smsgatewayhub.template_id'),
      ]);
    }
    return false;
  }

  /**
   * Check if user exists
   */
  public function userExistNot($mobileNo = null, $company_id = null)
  {
    return User::where('mobile', $mobileNo)->where('company_id', $company_id)->exists();
  }
}
