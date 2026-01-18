<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => ['auth', 'teacher_panel'], 'namespace' => 'App\Http\Controllers\Teacher'], function () {
  Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
  Route::resource('my-courses', 'MyCourseController')->names('my-courses');
  Route::prefix('my-courses/{identity}')->group(function () {
    Route::resource('schedule-class', 'MyCourseClassesController')
      ->names('my-courses.schedule-class');
    Route::resource('materials', 'MyCourseMaterialsController')
      ->names('my-courses.materials');
  });


  Route::resource('my-earns', 'MyEarnsController')->names('my-earns');
  Route::resource('my-schedules', 'MyScheduleController')->names('my-schedules');
  Route::resource('wallets', 'WalletController')->names('wallets');
  Route::resource('referral', 'ReferralController')->names('referral');
  Route::resource('performance', 'PerformanceController')->names('performance');
  Route::resource('settings', 'SettingsController')->names('settings');
  Route::post('settings/delete-request', 'SettingsController@accountDeleteRequest')->name('settings.account.delete');
  Route::post('settings/feedback', 'SettingsController@feedbackStore')->name('settings.feedback.store');

});
