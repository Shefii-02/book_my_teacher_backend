<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers\Api', 'prifix' => 'api'], function () {
  Route::post('user-exist-not', 'LoginController@userExistNot')->name('user-exist-no');

  Route::post('/send-otp-signIn', 'OtpController@sendOtpSignIn');
  Route::post('/verify-otp-signIn', 'OtpController@verifyOtpSignIn');

  Route::post('/send-otp-signUp', 'OtpController@sendOtpSignIn');
  Route::post('/verify-otp-signUp', 'OtpController@verifyOtpSignIn');

  Route::post('/send-email-otp', 'OtpController@sendEmailOtp');
  Route::post('/verify-email-otp', 'OtpController@verifyEmailOtp');

  Route::post('/teacher-signup', 'RegisterController@teacherSignup');
  Route::post('/student-signup', 'RegisterController@studentSignup');

  Route::post('/user-details', 'UserController@index');
  Route::post('/teacher-home', 'TeacherController@home');
  Route::post('/student-home', 'StudentController@home');


  Route::post('/teacher-profile', 'TeacherController@home');

  Route::post('/teacher-mycourses', 'TeacherController@home');

  Route::post('/student-profile', 'StudentController@home');

  Route::post('/notifications', 'UserController@notifications');



});
