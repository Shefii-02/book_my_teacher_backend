<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers\Api', 'prifix' => 'api'], function () {
  Route::post('user-exist-not', 'LoginController@userExistNot')->name('user-exist-no');

  Route::post('/send-otp-signIn', 'OtpController@sendOtpSignIn');
  Route::post('/verify-otp-signIn', 'OtpController@verifyOtpSignIn');

  Route::post('/send-otp-signUp', 'OtpController@sendOtpSignUp');
  Route::post('/verify-otp-signUp', 'OtpController@verifyOtpSignUp');

  Route::post('/send-email-otp', 'OtpController@sendEmailOtp');
  Route::post('/verify-email-otp', 'OtpController@verifyEmailOtp');

  Route::post('/teacher-signup', 'RegisterController@teacherSignup');
  Route::post('/student-signup', 'RegisterController@studentSignup');

  Route::post('/user-details', 'UserController@index');
  Route::post('/teacher-home', 'TeacherController@home');
  Route::post('/student-home', 'StudentController@home');

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


  Route::post('/check-user', function (\Illuminate\Http\Request $request) {
    $exists = \App\Models\User::where('id', $request->user_id)->exists();
    return response()->json(['exists' => $exists]);
  });
});
