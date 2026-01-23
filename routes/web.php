<?php

use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\HRMS\RoleController;
use App\Http\Controllers\HRMS\TeamController;
use App\Http\Controllers\LMS\AcademicController;
use App\Http\Controllers\LMS\AnalyticController;
use App\Http\Controllers\LMS\CouponController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LMS\CourseCategoryController;
use App\Http\Controllers\LMS\CourseClassController;
use App\Http\Controllers\LMS\CourseClassPermissionController;
use App\Http\Controllers\LMS\CourseController;
use App\Http\Controllers\LMS\CourseMaterialController;
use App\Http\Controllers\LMS\CourseSubCategoryController;
use App\Http\Controllers\LMS\LivestreamClassController;
use App\Http\Controllers\LMS\WebinarController;
use App\Http\Controllers\LMS\GuestController;
use App\Http\Controllers\LMS\GuestTeacherController;
use App\Http\Controllers\PhonePeController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Web\PhonePePaymentController;

Route::group(['namespace' => 'App\Http\Controllers'], function () {

  Route::get('/', function () {
    return view('web.index');
  });



Route::get('/pay', [PhonePePaymentController::class, 'checkout'])->name('phonepe.checkout');

Route::post('/phonepe/pay', [PhonePePaymentController::class, 'pay'])->name('phonepe.pay');

Route::any('/phonepe/callback', [PhonePePaymentController::class, 'callback'])->name('phonepe.callback');

Route::get('/payment/success', [PhonePePaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PhonePePaymentController::class, 'failed'])->name('payment.failed');


  // authentication
  // Route::get('/', 'auth\LoginController@index')->name('login');
  Route::get('/login', 'auth\LoginController@index')->name('login');
  Route::post('/', 'auth\LoginController@loginPost')->name('auth-login-post');

  Route::post('/logout', 'dashboard\UserController@logout')->name('logout');
  Route::get('admin/phonepe/pay', 'PhonePeController@initPayment');
  Route::get('admin/phonepe/callback', 'PhonePeController@callback')->name('phonepe.callback');
  Route::get('privacy-policy', function () {
    return view('privacy-policy');
  });
  Route::get('terms-conditions', function () {
    return view('terms-conditions');
  });
});



Route::get('/get-error', function () {
  $find = App\Models\User::find(100000)->id;
  return view('welcome');
});

Route::get('admin/webinar', function () {
  $app_id          = env('ZEGO_APP_ID');
  $secret_id       = env('ZEGO_SERVER_SECRET');

  return view('company.webinar.index', compact('app_id', 'secret_id'));
});



//////////////////////////////////////////////////////////////////////////

Route::get('/invite', [ReferralController::class, 'trackReferral']);



require __DIR__ . '/admin.php';
require __DIR__ . '/company.php';
require __DIR__ . '/teacher.php';
