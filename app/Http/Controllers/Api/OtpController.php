<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Traits\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
  use JsonResponseTrait;
  use \App\Emails;

  /**
   * Send OTP to user via SMS Gateway Hub
   */
  public function sendOtp(Request $request)
  {

    $request->validate([
      'mobile' => 'required|digits:12',
    ]);

    // $company_id = 1;
    $mobile = $request->mobile; // add country code

    // $otp = rand(1000, 9999);

    // $expTime = 20;

    // // Save OTP in database
    // Otp::create([
    //   'mobile'     => $mobile,
    //   'otp'        => $otp,
    //   'expires_at' => Carbon::now()->addMinutes($expTime),
    //   'company_id' => $company_id,
    //   'type'       => 'mobile'
    // ]);


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

  /**
   * Verify OTP
   */
  public function verifyOtp(Request $request)
  {
    $request->validate([
      'mobile' => 'required',
      'otp'    => 'required',
    ]);

    $mobile = $request->mobile;
    $otpInput = $request->otp;
    $otpRecord = Otp::where('mobile', $mobile)
      ->where('otp', $otpInput)
      ->where('verified', false)
      ->where('expires_at', '>=', now())
      ->latest()
      ->first();

    if ($otpRecord) {
      $otpRecord->update(['verified' => true]);

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
}
