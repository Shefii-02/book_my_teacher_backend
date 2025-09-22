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

  Route::post('/re-send-otp', 'OtpController@reSendOtp');



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


  Route::post('/fetch-grades', function () {
    return response()->json([
      'status' => true,
      'data' => [
        ['id' => 1,  'name' => 'Pre-Primary / Kindergarten'],
        ['id' => 2, 'name' => 'Lower Primary'],
        ['id' => 3, 'name' => 'Up to 10th'],
        ['id' => 4, 'name' => 'Higher Secondary'],
        ['id' => 5, 'name' => 'Under/Post Graduate Level'],
        ['id' => 6, 'name' => 'Competitive Exams'],
        ['id' => 7, 'name' => 'Skills Development'],
      ]
    ]);
  });


  Route::post('/fetch-subjects', function () {
    return response()->json([
      'status' => true,
      'data' => [
        // Common subjects
        ['id' => 1, 'name' => 'All Subjects'],
        ['id' => 2, 'name' => 'Mathematics'],
        ['id' => 3, 'name' => 'Science'],
        ['id' => 4, 'name' => 'English'],
        ['id' => 5, 'name' => 'Social Studies'],
        ['id' => 6, 'name' => 'Computer Science'],

        // Higher Secondary
        ['id' => 7, 'name' => 'Physics'],
        ['id' => 8, 'name' => 'Chemistry'],
        ['id' => 9, 'name' => 'Biology'],

        // UG/PG
        ['id' => 10, 'name' => 'Commerce'],
        ['id' => 11, 'name' => 'Economics'],
        ['id' => 12, 'name' => 'Engineering Subjects'],
        ['id' => 13, 'name' => 'Medical Subjects'],

        // Competitive Exams
        ['id' => 14, 'name' => 'General Knowledge'],
        ['id' => 15, 'name' => 'Quantitative Aptitude'],
        ['id' => 16, 'name' => 'Reasoning'],
        ['id' => 17, 'name' => 'Current Affairs'],

        // Skills
        ['id' => 18, 'name' => 'Spoken English'],
        ['id' => 19, 'name' => 'Programming'],
        ['id' => 20, 'name' => 'Digital Marketing'],
        ['id' => 21, 'name' => 'Designing'],
      ]
    ]);
  });



  Route::post('/check-user', function (\Illuminate\Http\Request $request) {
    $exists = \App\Models\User::where('id', $request->user_id)->where('acc_type', $request->acc_type)->exists();
    return response()->json(['exists' => $exists]);
  });
});
