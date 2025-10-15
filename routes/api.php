<?php

use App\Http\Controllers\Api\WebinarController;
use App\Http\Controllers\Api\WebinarRegistrationController;
use App\Http\Controllers\Api\ZegoTokenController;
use App\Http\Resources\WebinarResource;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use Google\Client as GoogleClient;


Route::group(['namespace' => 'App\Http\Controllers\Api', 'prifix' => 'api'], function () {



  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/guest-signup', 'RegisterController@guestSignup');
  });


  Route::post('/teacher-signup', 'RegisterController@teacherSignup');
  Route::post('/student-signup', 'RegisterController@studentSignup');

  Route::get('/check-server', 'UserController@checkServer');
  Route::post('user-exist-not', 'LoginController@userExistNot')->name('user-exist-no');


  Route::post('/get-user-details', 'UserController@getUserDetails')->middleware('auth:sanctum');
  Route::post('/set-user-token', 'UserController@setUserToken');


  Route::post('/send-otp-signIn', 'OtpController@sendOtpSignIn');
  Route::post('/verify-otp-signIn', 'OtpController@verifyOtpSignIn');

  Route::post('/send-otp-signUp', 'OtpController@sendOtpSignUp');
  Route::post('/verify-otp-signUp', 'OtpController@verifyOtpSignUp');

  Route::post('/send-email-otp', 'OtpController@sendEmailOtp');
  Route::post('/verify-email-otp', 'OtpController@verifyEmailOtp');

  Route::post('/re-send-otp', 'OtpController@reSendOtp');




  Route::post('/user-details', 'UserController@index');
  Route::post('/teacher-home', 'TeacherController@home');
  Route::post('/student-home', 'StudentController@home');
  Route::post('/guest-home', 'GuestController@home');


  // Route::post('/teacher-profile', 'TeacherController@home');

  // Route::post('/teacher-mycourses', 'TeacherController@home');

  // Route::post('/student-profile', 'StudentController@home');

  // Route::post('/notifications', 'UserController@notifications');

  Route::any('upload', function (Request $request) {
    Log::info($request->all());
    $source = $request->header('X-Request-Source', 'Unknown');

    // if ($request->hasFile('avatar')) {
    //     $avatarPath = $request->file('avatar')->store('avatars', 'public');
    // }

    // if ($request->hasFile('cv')) {
    //     $cvPath = $request->file('cv')->store('cvs', 'public');
    // }
    return response()->json([
      'message' => 'Files uploaded successfully',
      'source' => $source,
      'avatar' => "avatarPath" ?? null,
      'cv' => "cvPath" ?? null,
    ]);
  });


  // Route::middleware('auth:sanctum')->group(function () {
  // Route::any('webinars-list', function (Request $request) {

  //   $data = Webinar::get();
  //   Log::info($data);
  //   return response()->json([
  //     'status' => true,
  //     'data' => WebinarResource::collection($data),
  //   ]);
  // })->middleware('auth:sanctum');

  Route::post('/webinars', 'WebinarApiController@index')->middleware('auth:sanctum');
  Route::post('/webinars/{id}', 'WebinarApiController@show');
  Route::post('/webinars/{id}/live', 'WebinarApiController@liveDetails');
  Route::post('/webinars/{id}/register', 'WebinarApiController@register')->middleware('auth:sanctum');
  Route::post('/webinars/{id}/join', 'WebinarApiController@join')->middleware('auth:sanctum');
  // });

  // Public webinar listing and detail
  // Route::get('webinars', [WebinarController::class, 'index']);
  // Route::get('webinars/{webinar}', [WebinarController::class, 'show']);

  // // Protected routes — add auth middleware as needed
  // Route::post('webinars', [WebinarController::class, 'store']);       // create
  // Route::put('webinars/{webinar}', [WebinarController::class, 'update']);
  // Route::delete('webinars/{webinar}', [WebinarController::class, 'destroy']);

  // // Start/end (host)
  // Route::post('webinars/{webinar}/start', [WebinarController::class, 'start']);
  // Route::post('webinars/{webinar}/end', [WebinarController::class, 'end']);

  // registration
  // Route::post('webinars/{webinar}/register', [WebinarRegistrationController::class, 'store']);
  // Route::get('webinars/{webinar}/registrations', [WebinarRegistrationController::class, 'index']);

  // // registered webinars for a user
  // Route::get('registrations', [WebinarRegistrationController::class, 'registeredForUser']);

  // // token generation for joining ZEGOCLOUD
  // Route::post('webinars/{webinar}/token', [ZegoTokenController::class, 'generate']);


  Route::get('/fetch-grades', function () {
    return response()->json([
      'status' => true,
      'data' => Grade::all()
    ]);
  });

  Route::get('/fetch-subjects', function () {
    return response()->json([
      'status' => true,
      'data' => Subject::all()
    ]);
  });

  // Route::get('/fetch-grades', function () {
  //   return response()->json([
  //     'status' => true,
  //     'data' => [
  //       ['id' => 1, 'name' => 'Pre-Primary / Kindergarten', 'value' => 'Pre-Primary / Kindergarten'],
  //       ['id' => 2, 'name' => 'Lower Primary', 'value' => 'Lower Primary'],
  //       ['id' => 3, 'name' => 'Up to 10th', 'value' => 'Up to 10th'],
  //       ['id' => 4, 'name' => 'Higher Secondary', 'value' => 'Higher Secondary'],
  //       ['id' => 5, 'name' => 'Under/Post Graduate Level', 'value' => 'Under/Post Graduate Level'],
  //       ['id' => 6, 'name' => 'Competitive Exams', 'value' => 'Competitive Exams'],
  //       ['id' => 7, 'name' => 'Skill Development', 'value' => 'Skill Development'],
  //     ]
  //   ]);
  // });





  // Route::get('/fetch-subjects', function () {
  //   return response()->json([
  //     'status' => true,
  //     'data' => [
  //       // Common subjects
  //       ['id' => 1, 'name' => 'All Subjects', 'value' => 'All Subjects'],
  //       ['id' => 2, 'name' => 'Mathematics', 'value' => 'Mathematics'],
  //       ['id' => 3, 'name' => 'Science', 'value' => 'Science'],
  //       ['id' => 4, 'name' => 'English', 'value' => 'English'],
  //       ['id' => 5, 'name' => 'Social Studies', 'value' => 'Social Studies'],
  //       ['id' => 6, 'name' => 'Computer Science', 'value' => 'Computer Science'],

  //       // Higher Secondary
  //       ['id' => 7, 'name' => 'Physics', 'value' => 'Physics'],
  //       ['id' => 8, 'name' => 'Chemistry', 'value' => 'Chemistry'],
  //       ['id' => 9, 'name' => 'Biology', 'value' => 'Biology'],

  //       // UG/PG
  //       ['id' => 10, 'name' => 'Commerce', 'value' => 'Commerce'],
  //       ['id' => 11, 'name' => 'Economics', 'value' => 'Economics'],
  //       ['id' => 12, 'name' => 'Engineering Subjects', 'value' => 'Engineering Subjects'],
  //       ['id' => 13, 'name' => 'Medical Subjects', 'value' => 'Medical Subjects'],

  //       // Competitive Exams
  //       ['id' => 14, 'name' => 'General Knowledge', 'value' => 'General Knowledge'],
  //       ['id' => 15, 'name' => 'Quantitative Aptitude', 'value' => 'Quantitative Aptitude'],
  //       ['id' => 16, 'name' => 'Reasoning', 'value' => 'Reasoning'],
  //       ['id' => 17, 'name' => 'Current Affairs', 'value' => 'Current Affairs'],

  //       // Skills
  //       ['id' => 18, 'name' => 'Spoken English', 'value' => 'Spoken English'],
  //       ['id' => 19, 'name' => 'Programming', 'value' => 'Programming'],
  //       ['id' => 20, 'name' => 'Digital Marketing', 'value' => 'Digital Marketing'],
  //       ['id' => 21, 'name' => 'Designing', 'value' => 'Designing'],
  //     ]
  //   ]);
  // });

  Route::post('/user-activity', [App\Http\Controllers\Api\UserActivityController::class, 'store']);


  Route::post('/check-user', function (\Illuminate\Http\Request $request) {
    $exists = \App\Models\User::where('id', $request->user_id)->where('acc_type', $request->acc_type)->exists();
    return response()->json(['exists' => $exists]);
  });

  // Route::post('/google-login-check', function (\Illuminate\Http\Request $request) {

  //   $idToken = $request->idToken;


  //   Log::info($idToken);

  //   $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);
  //   $payload = $client->verifyIdToken($idToken);

  //   if (!$payload) {
  //     Log::info($payload);
  //     return response()->json(['status' => 'error', 'message' => 'Invalid ID token'], 401);
  //   }

  //   Log::info('payload' . $payload);
  //   $email = $payload['email'];
  //   $user = User::where('email', $email)->first();

  //   if (!$user) {
  //     Log::info('status error' . $email);
  //     return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
  //   }

  //   // Optionally create your own JWT / sanctum token
  //   // $token = $user->createToken('google_login')->plainTextToken;
  //   // Log::info('token' . $token);
  //   return response()->json([
  //     'status' => 'success',
  //     // 'token'  => $token,
  //     'user'   => $user,
  //   ]);
  // });
  Route::post('/google-login-check', function (Request $request) {
    try {
      $idToken = $request->input('idToken');

      if (!$idToken) {
        return response()->json(['status' => 'error', 'message' => 'Missing idToken']);
      }

      // ✅ Verify token using Google API client
      $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
      $payload = $client->verifyIdToken($idToken);

      if (!$payload) {
        return response()->json(['status' => 'error', 'message' => 'Invalid Google token']);
      }

      $email = $payload['email'] ?? null;

      if (!$email) {
        return response()->json(['status' => 'error', 'message' => 'Email not found in token']);
      }

      // ✅ Check if email exists in your users table
      $user = \App\Models\User::where('email', $email)->first();

      if ($user) {
        return response()->json(['status' => 'success', 'user' => $user]);
      } else {
        return response()->json([
          'status' => 'error',
          'message' => 'Account not found. Please sign up normally.',
        ]);
      }
    } catch (Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage(),
      ]);
    }
  });
});
