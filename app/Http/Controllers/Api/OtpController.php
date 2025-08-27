<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Traits\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
  use JsonResponseTrait;
  use \App\Emails;


  /**
   * Send OTP to user via SMS Gateway Hub
   */
  public function sendOtpSignIn(Request $request)
  {
    $request->validate([
      'mobile' => 'required|digits:10',
    ]);

    $company_id = 1;

    $mobile = '91' + $request->mobile; // add country code

    //check user exist or not
    $userExist = $this->userExistNot($mobile, $company_id);

    if (!$userExist) {
      return $this->error('User not found', Response::HTTP_NOT_FOUND);
    }

    $otp = rand(1000, 9999);

    $expTime = 20;

    // // Save OTP in database
    Otp::create([
      'mobile'     => $mobile,
      'otp'        => $otp,
      'expires_at' => Carbon::now()->addMinutes($expTime),
      'company_id' => $company_id,
      'type'       => 'mobile',
      'attempt'    => '1'
    ]);

    $response = $this->SmsApiFunction($mobile, $otp);
    // // Send OTP via SMS Gateway Hub API
    // $response = Http::get("https://www.smsgatewayhub.com/api/mt/SendSMS", [
    //   'APIKey'        => config('services.smsgatewayhub.key'),
    //   'senderid'      => config('services.smsgatewayhub.senderid'),
    //   'channel'       => 2,
    //   'DCS'           => 0,
    //   'flashsms'      => 0,
    //   'number'        => $mobile,
    //   'text'          => "{$otp} is your One Time Password (OTP) for login/signup at BookMyTeacher By Pachavellam Education.This OTP will only be valid for {$expTime} minutes. Do not share anyone",
    //   'route'         => 54,
    //   'EntityId'      => config('services.smsgatewayhub.entity_id'),
    //   'dlttemplateid' => config('services.smsgatewayhub.template_id'),
    // ]);

    if (isset($response) && $response->successful()) {
      return $this->success('OTP sent successfully', ['mobile' => $mobile]);
    }

    return $this->error('Failed to send OTP', Response::HTTP_BAD_REQUEST);
  }

  public function sendOtpSignUp(Request $request)
  {
    $request->validate([
      'mobile' => 'required|digits:10',
    ]);

    $company_id = 1;
    $mobile = '91' + $request->mobile; // add country code

    $otp = rand(1000, 9999);

    $expTime = 20;

    $userExist = $this->userExistNot($mobile, $company_id);

    if ($userExist) {
      return $this->error('User already signed..', Response::HTTP_NOT_FOUND);
    }

    // // Save OTP in database
    Otp::create([
      'mobile'     => $mobile,
      'otp'        => $otp,
      'expires_at' => Carbon::now()->addMinutes($expTime),
      'company_id' => $company_id,
      'type'       => 'mobile',
      'attempt'    => '1'
    ]);

    $response = $this->SmsApiFunction($mobile, $otp);

    if (isset($response) && $response->successful()) {
      return $this->success('OTP sent successfully', ['mobile' => $mobile]);
    }

    return $this->error('Failed to send OTP', Response::HTTP_BAD_REQUEST);
  }


  /**
   * Verify OTP
   */
  public function verifyOtpSignIn(Request $request)
  {
    $request->validate([
      'mobile' => 'required',
      'otp'    => 'required',
    ]);

    $mobile = $request->mobile;
    $otpInput = $request->otp;
    $otpRecord = Otp::where('mobile', $mobile)
      ->where('otp', $otpInput)
      ->where('verified', 0)
      ->where('expires_at', '>=', now())
      ->latest()
      ->first();

    if ($otpRecord) {
      $otpRecord->update(['verified' => true]);

      $user = User::where('mobile', $mobile)->where('company_id', 1)->first();

      if (!$user) {
        $user                     = new User();
        $user->name               = null;
        $user->mobile             = $mobile;
        $user->mobile_verified    = true;
        $user->company_id         = 1;
        $user->last_login         = null;
        $user->email              = null;
        $user->email_verified_at  = null;
        $user->password           = null;
        $user->save();
      } else {
        $user->mobile_verified    = true;
        $user->save();
      }

      return $this->success('OTP verified successfully');
    }

    return $this->error('Invalid or expired OTP', Response::HTTP_UNAUTHORIZED);
  }

  public function verifyOtpSignUp(Request $request)
  {
    $request->validate([
      'mobile' => 'required',
      'otp'    => 'required',
    ]);

    $mobile = $request->mobile;
    $otpInput = $request->otp;
    $company_id = 1;

    $otpRecord = Otp::where('mobile', $mobile)
      ->where('otp', $otpInput)
      ->where('verified', 0)
      ->where('expires_at', '>=', now())
      ->latest()
      ->first();

    if ($otpRecord) {
      $otpRecord->update(['verified' => true]);

      $user                 = new User();
      $user->mobile         = $mobile;
      $user->mobile_verified = true;
      $user->company_id     = $company_id;
      $user->email          = null;
      $user->name           = null;
      $user->acc_type       = null;
      $user->save();

      return $this->success('OTP verified successfully');
    }

    return $this->error('Invalid or expired OTP', Response::HTTP_UNAUTHORIZED);
  }


  public function sendEmailOtp(Request $request)
  {
    $request->validate([
      'email' => 'required|email'
    ]);

    $email = $request->email;
    $company_id = 1;
    $otp = rand(1000, 9999);
    $expTime = 20;

    // Save OTP in DB
    Otp::create([
      'mobile'     => $email,
      'otp'        => $otp,
      'expires_at' => Carbon::now()->addMinutes($expTime),
      'company_id' => $company_id,
      'type'       => 'email'
    ]);

    try {

      $this->SendOtpMail($otp, $expTime, $email);

      return $this->success('OTP sent successfully', ['email' => $email]);
    } catch (\Exception $e) {
      return $this->error('Failed to send OTP: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
    }
  }


  public function verifyEmailOtp(Request $request)
  {
    $request->validate([
      'email' => 'required',
      'otp'    => 'required',
    ]);

    $email = $request->email;
    $otpInput = $request->otp;
    $otpRecord = Otp::where('mobile', $email)
      ->where('otp', $otpInput)
      ->where('verified', false)
      ->where('expires_at', '>=', now())
      ->where('type', 'email')
      ->latest()
      ->first();

    if ($otpRecord) {
      $otpRecord->update(['verified' => true]);

      return $this->success('OTP verified successfully');
    }

    return $this->error('Invalid or expired OTP', Response::HTTP_UNAUTHORIZED);
  }


  private function SmsApiFunction($mobile = null, $otp = null)
  {
    if ($mobile != null && $otp != null && env('SMSOTP', true)) {
      // // Send OTP via SMS Gateway Hub API
      $response = Http::get("https://www.smsgatewayhub.com/api/mt/SendSMS", [
        'APIKey'        => config('services.smsgatewayhub.key'),
        'senderid'      => config('services.smsgatewayhub.senderid'),
        'channel'       => 2,
        'DCS'           => 0,
        'flashsms'      => 0,
        'number'        => $mobile,
        'text'          => "{$otp} is your One Time Password (OTP) for login/signup at BookMyTeacher By Pachavellam Education.This OTP will only be valid for {$expTime} minutes. Do not share anyone",
        'route'         => 54,
        'EntityId'      => config('services.smsgatewayhub.entity_id'),
        'dlttemplateid' => config('services.smsgatewayhub.template_id'),
      ]);
      return $response;
    }

    return false;
  }


  public function userExistNot($mobileNo = null, $company_id = null)
  {
    $user =  User::where('mobile', $mobileNo)->where('company_id', $company_id)->first();
    if ($user) {
      return true;
    } else {
      return false;
    }
  }
}
