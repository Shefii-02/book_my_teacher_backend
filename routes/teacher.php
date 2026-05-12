<?php

use App\Http\Controllers\Teacher\ActivityLogController;
use App\Http\Controllers\Teacher\NotificationController;
use App\Http\Controllers\Teacher\DemoScheduledClassController;
use App\Http\Controllers\Teacher\MyScheduleController;
use App\Http\Controllers\Teacher\ReviewRatingController;
use App\Http\Controllers\Teacher\SettingsController;
use App\Http\Controllers\Teacher\StatisticsController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => ['auth', 'teacher_panel'], 'namespace' => 'App\Http\Controllers\Teacher'], function () {
  Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
  Route::resource('my-courses', 'MyCourseController')->names('my-courses');
  Route::prefix('my-courses/{identity}')->group(function () {

    Route::get('schedule-class/attendance/{schedule_class}', 'MyCourseClassesController@attendanceTake')->name('my-courses.schedule-class.attendance.edit');
    Route::post('schedule-class/attendance/{schedule_class}', 'MyCourseClassesController@attendanceUpdate')->name('my-courses.schedule-class.attendance.update');
    Route::get('schedule-class/duration/{schedule_class}', 'MyCourseClassesController@durationEdit')->name('my-courses.schedule-class.duration.edit');
    Route::post('schedule-class/duration/{schedule_class}', 'MyCourseClassesController@durationUpdate')->name('my-courses.schedule-class.duration.update');

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
  Route::get(
    '/settings',
    [SettingsController::class, 'index']
  )->name('settings.index');

  Route::post(
    '/settings/profile/update',
    [SettingsController::class, 'updateProfile']
  )->name('settings.profile.update');

  Route::post(
    '/settings/teaching/update',
    [SettingsController::class, 'updateProfessional']
  )->name('settings.teaching.update');



  Route::post(
    '/settings/professional/update',
    [SettingsController::class, 'updateExtraInfo']
  )->name('settings.extra.update');


    Route::get(
    '/settings/slots/update',
    [SettingsController::class, 'editTeachingSlots']
  )->name('settings.teachers.slots.edit');

  Route::post(
    '/settings/slots/update',
    [SettingsController::class, 'updateTeachingSlots']
  )->name('settings.teachers.slots.update');

  Route::get('settings/grades/edit', [SettingsController::class,'editTeachingGrades'])->name('settings.teachers.grades.edit');

  Route::post(
    '/settings/grades/update',
    [SettingsController::class, 'updateTeachingGrades']
  )->name('settings.teachers.grades.update');



  Route::get('teachers/{id}/slots/edit', 'TeacherController@teachingSlotEdit')->name('teachers.slots.edit');

    Route::post('settings/change-password', 'SettingsController@changePassword')->name('settings.profile.changePassword');




  // Route::resource('settings', 'SettingsController')->names('settings');
  Route::post('settings/delete-request', 'SettingsController@accountDeleteRequest')->name('settings.account.delete');
  Route::post('settings/feedback', 'SettingsController@feedbackStore')->name('settings.feedback.store');
});


Route::prefix('teacher')
  ->name('teacher.')
  ->middleware(['auth'])
  ->group(function () {



    Route::resource('demo-classes', DemoScheduledClassController::class)->names('demo-classes');

    Route::get('today-sessions', [MyScheduleController::class, 'todayClasses'])->name('today-sessions.index');



    Route::resource('statistics', StatisticsController::class)->names('statistics');

    Route::resource('reviews', ReviewRatingController::class)->names('reviews');

    // web.php


    Route::get(
      '/notifications',
      [NotificationController::class, 'index']
    )->name('notifications.index');

    Route::get(
      '/notifications/read/{id}',
      [NotificationController::class, 'markAsRead']
    )->name('notifications.read');

    Route::get(
      '/notifications/read-all',
      [NotificationController::class, 'markAllAsRead']
    )->name('notifications.read-all');


    Route::resource('activity-logs', ActivityLogController::class)->names('activity-logs');
  });
