<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers\Api', 'prifix' => 'api'], function () {
  Route::post('user-exist-not', 'LoginController@userExistNot')->name('user-exist-no');

  Route::post('/send-otp', 'OtpController@sendOtp');
  Route::post('/verify-otp', 'OtpController@verifyOtp');


  Route::post('/send-email-otp', 'OtpController@sendEmailOtp');
  Route::post('/verify-email-otp', 'OtpController@verifyEmailOtp');


});
