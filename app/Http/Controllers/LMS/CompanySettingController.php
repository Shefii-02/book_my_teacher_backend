<?php

namespace App\Http\Controllers\LMS;

use App\Models\CompanyGeneralSetting;
use App\Models\CompanyBranding;
use App\Models\CompanySocialLink;
use App\Models\CompanyPaymentSetting;
use App\Models\CompanySecuritySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyContact;
use App\Models\Otp;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\UserPlatform;
use Carbon\Carbon;

class CompanySettingController extends Controller
{
  public function index()
  {
    $companyId = auth()->user()->company_id;

    return view('company.settings.index', [
      'general'     => CompanyContact::where('company_id', $companyId)->first(),
      'company'    => Company::where('id', $companyId)->first(),
      'branding'    => CompanyBranding::where('company_id', $companyId)->first(),
      'socialLinks' => SocialLink::where(
        'company_id',
        $companyId
      )
        ->where('category', 'socialmedia')
        ->orderBy('sort_order')
        ->get(),

      'communityLinks' => SocialLink::where(
        'company_id',
        $companyId
      )
        ->where('category', 'community')
        ->orderBy('sort_order')
        ->get(),
      'payment'     => CompanyPaymentSetting::where('company_id', $companyId)->first(),
      'security'    => CompanySecuritySetting::where('company_id', $companyId)->first(),
    ]);
  }

  public function updateGeneral(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    CompanyContact::updateOrCreate(
      ['company_id' => $companyId],
      $request->only(['email', 'phone', 'website', 'whatsapp', 'address'])
    );

    return back()->with('success', 'General settings updated');
  }

  public function updateBranding(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    $branding = Company::firstOrNew(['id' => $companyId]);


    if ($request->hasFile('black_logo')) {
      $file = $request->file('black_logo');
      $filename = time() . "-" . $file->getClientOriginalName();
      $file->move(public_path('uploads/branding'), $filename);
      $branding->black_logo = '/uploads/branding/' . $filename;
    }



    if ($request->hasFile('white_logo')) {
      $file = $request->file('white_logo');
      $filename = time() . "-" . $file->getClientOriginalName();
      $file->move(public_path('uploads/branding'), $filename);
      $branding->white_logo = '/uploads/branding/' . $filename;
    }



    if ($request->hasFile('favicon')) {
      $file = $request->file('favicon');
      $filename = time() . "-" . $file->getClientOriginalName();
      $file->move(public_path('uploads/branding'), $filename);
      $branding->favicon = '/uploads/branding/' . $filename;
    }


    $branding->save();

    $theme = CompanyBranding::firstOrNew(['company_id' => $companyId]);

    $theme->theme_color = $request->theme_color;
    $theme->save();

    return back()->with('success', 'Branding updated');
  }

  public function updateSocial(Request $request)
  {
    $companyId = auth()->user()->company_id;

    $category = $request->category;
    // socialmedia or community

    foreach ($request->links ?? [] as $id => $data) {

      if ($id == 0) {

        $social = new SocialLink();
        $social->company_id = $companyId;
      } else {

        $social = SocialLink::where(
          'id',
          $id
        )
          ->where(
            'company_id',
            $companyId
          )
          ->first();

        if (!$social) {
          continue;
        }
      }

      $social->name =
        $data['name'] ?? '';

      $social->link =
        $data['link'] ?? null;

      $social->sort_order =
        $data['sort_order'] ?? 0;

      $social->category =
        $category;

      $social->is_active = 1;

      if (
        isset($data['icon']) &&
        $data['icon']
      ) {

        $file = $data['icon'];

        $filename =
          time() .
          '-' .
          $file->getClientOriginalName();

        $file->move(
          public_path(
            'uploads/social_icons'
          ),
          $filename
        );

        $social->icon =
          '/uploads/social_icons/'
          . $filename;
      }

      $social->save();
    }

    return back()->with(
      'success',
      ucfirst($category)
        . ' links updated'
    );
  }


  public function deleteSocial($id)
  {
    $link = SocialLink::findOrFail($id);
    $link->delete();

    return back()->with('success', 'Social link deleted');
  }


  public function updatePayment(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    CompanyPaymentSetting::updateOrCreate(
      ['company_id' => $companyId],
      $request->only(['merchant_id', 'salt_key', 'salt_index'])
    );

    return back()->with('success', 'Payment settings updated');
  }

  public function updateSecurity(Request $request)
  {
    // $companyId = app('company_id');
    $companyId = auth()->user()->company_id;
    CompanySecuritySetting::updateOrCreate(
      ['company_id' => $companyId],
      [
        'two_factor_enabled' => $request->has('two_factor_enabled'),
        'maintenance_mode'   => $request->has('maintenance_mode'),
      ]
    );

    return back()->with('success', 'Security settings updated');
  }

  public function userDevices($id)
  {
    return UserPlatform::where('user_id', $id)->whereNotNull(
      'fcm_token'
    )
      ->get();
  }

  public function sendTestPush(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'message' => 'required',
      'device_ids' => 'required|array'
    ]);


    $devices = \App\Models\UserPlatform::whereIn(
      'id',
      $request->device_ids
    )->where('user_id', $request->user_id)
      ->whereNotNull('fcm_token')
      ->get();



    if ($devices->isEmpty()) {
      return back()->with(
        'error',
        'No valid device tokens found'
      );
    }

    try {

      $jsonPath = storage_path(
        'app/json/fcm-file.json'
      );

      $scopes = [
        'https://www.googleapis.com/auth/firebase.messaging'
      ];

      $credentials =
        new \Google\Auth\Credentials\ServiceAccountCredentials(
          $scopes,
          $jsonPath
        );

      $tokenArray =
        $credentials->fetchAuthToken();

      $accessToken =
        $tokenArray['access_token'];

      if (!$accessToken) {
        return back()->with(
          'error',
          'Access token failed'
        );
      }

      $config =
        json_decode(
          file_get_contents($jsonPath),
          true
        );

      $projectId =
        $config['project_id'];

      $url =
        "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

      $client =
        new \GuzzleHttp\Client();

      $success = 0;
      $failed = 0;

      foreach (
        $devices as $device
      ) {

        try {

          $payload = [

            'message' => [

              'token' =>
              $device->fcm_token,

              'notification' => [
                'title' =>
                $request->title,

                'body' =>
                $request->message
              ],

              'data' => [
                'click_action' =>
                'FLUTTER_NOTIFICATION_CLICK',

                'type' =>
                'admin_test'
              ],

              'android' => [
                'priority' => 'high'
              ],

              'apns' => [
                'payload' => [
                  'aps' => [
                    'sound' => 'default'
                  ]
                ]
              ]

            ]

          ];


          $client->post(
            $url,
            [
              'headers' => [
                'Authorization' =>
                "Bearer {$accessToken}",

                'Content-Type' =>
                'application/json'
              ],

              'json' => $payload
            ]
          );

          $success++;
        } catch (\Exception $e) {

          \Log::error(
            'Push failed: ' .
              $e->getMessage()
          );

          $failed++;
        }
      }

      return back()->with(
        'success',
        "{$success} sent, {$failed} failed"
      );
    } catch (\Exception $e) {

      \Log::error(
        'FCM error: ' .
          $e->getMessage()
      );

      return back()->with(
        'error',
        $e->getMessage()
      );
    }
  }


  public function searchUsers(Request $request)
  {
    $q = $request->q;
    $users =  User::where('name', 'like', "%$q%")->orWhere('phone', 'like', "%$q%")->limit(10)->get(['id', 'name', 'phone']);
    return $users;
  }

  public function sendTestOtp(Request $request)
  {
    $request->validate([
      'user_id' => 'required',
    ]);

    $company_id = auth()->user()->company_id;
    $user = User::where('id', $request->user_id)->where('company_id', $company_id)->first();
    $mobile = $user->mobile;
    $expTime = 20;

    // check user exists
    if (!$user) {
      return redirect()->back('User not found Please Sign up Account');
    }


    // check existing unverified otp
    $existingOtp = Otp::where('mobile', $mobile)
      ->where('company_id', $company_id)
      ->where('verified', 0) // unverified
      ->orderBy('created_at', 'DESC')
      ->first();

    if ($existingOtp) {
      // Reuse old otp → update expiry + attempt
      $existingOtp->update([
        'attempt'    => $existingOtp->attempt + 1,
        'expires_at' => Carbon::now()->addMinutes($expTime),
      ]);

      $otp = $existingOtp->otp;
    } else {
      // Generate new OTP
      $otp = rand(1000, 9999);

      Otp::create([
        'mobile'     => $mobile,
        'otp'        => $otp,
        'expires_at' => Carbon::now()->addMinutes($expTime),
        'company_id' => $company_id,
        'type'       => 'mobile',
        'attempt'    => 1
      ]);
    }

    // send otp
    $response = $this->SmsApiFunction($mobile, $otp, $expTime);

    if ($response && $response->successful()) {
      return redirect()->back()->with('success', "OTP sent Successfully mobile = $mobile");
    } else if (!env('SMSOTP', false)) {
      return redirect()->back()->with('error', "OTP sent Error (Debug Mode)= $mobile");
    }

    return redirect()->back()->with('error', "Failed to send OTP mobile = $mobile");
  }

  /**
   * Reusable SMS Function
   */
  private function SmsApiFunction($mobile = null, $otp = null, $expTime = 20)
  {
    if ($mobile && $otp && env('SMSOTP', true)) {
      $response =  Http::get("https://www.smsgatewayhub.com/api/mt/SendSMS", [
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
}
