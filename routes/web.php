<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LMS\CourseCategoryController;
use App\Http\Controllers\LMS\CourseClassController;
use App\Http\Controllers\LMS\CourseClassPermissionController;
use App\Http\Controllers\LMS\CourseController;
use App\Http\Controllers\LMS\CourseSubCategoryController;
use App\Http\Controllers\LMS\LivestreamClassController;
use App\Http\Controllers\LMS\WebinarController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
  // authentication
  Route::get('/', 'auth\LoginController@index')->name('login');
  Route::post('/', 'auth\LoginController@loginPost')->name('auth-login-post');

  Route::post('/logout', 'dashboard\UserController@logout')->name('logout');
});



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth'], 'namespace' => 'App\Http\Controllers'], function () {
  // Main Page Route
  Route::get('/', 'dashboard\Analytics@index');
  Route::get('/dashboard', 'dashboard\Analytics@index')->name('dashboard');
  Route::get('/profile', 'dashboard\UserController@profile')->name('profile');

  Route::put('/profile', 'dashboard\UserController@update')->name('profile.update');
  Route::post('/profile', 'dashboard\UserController@changePassword')->name('profile.changePassword');

  Route::get('/teachers', 'LMS\TeacherController@index')->name('teachers');
  Route::get('/teachers/create', 'LMS\TeacherController@create')->name('teachers.create');
  Route::post('/teachers/store', 'LMS\TeacherController@store')->name('teachers.store');
  Route::get('teachers/{id}', 'LMS\TeacherController@overview')->name('teachers.overview');   // Overview
  Route::get('teachers/{id}/edit', 'LMS\TeacherController@edit')->name('teachers.edit');
  Route::put('teachers/{id}/edit', 'LMS\TeacherController@update')->name('teachers.update');  // Edit
  Route::delete('teachers/{id}', 'LMS\TeacherController@delete')->name('teachers.destroy');  // Delete
  Route::get('teachers/{id}/login-security', 'LMS\TeacherController@loginSecurity')->name('teachers.login-security');
  Route::post('teachers/{id}/login-security', 'LMS\TeacherController@loginSecurityChange')->name('teachers.login-security.change');

  Route::get('/students', 'LMS\StudentController@index')->name('students');
  Route::get('/students/create', 'LMS\StudentController@create')->name('students.create');
  Route::post('/students/store', 'LMS\StudentController@store')->name('students.store');
  Route::get('students/{id}', 'LMS\StudentController@overview')->name('students.overview');   // Overview
  Route::get('students/{id}/edit', 'LMS\StudentController@edit')->name('students.edit');
  Route::put('students/{id}/edit', 'LMS\StudentController@update')->name('students.update');  // Edit
  Route::delete('students/{id}', 'LMS\StudentController@delete')->name('students.destroy');  // Delete
  Route::get('students/{id}/login-security', 'LMS\StudentController@loginSecurity')->name('students.login-security');
  Route::post('students/{id}/login-security', 'LMS\StudentController@loginSecurityChange')->name('students.login-security.change');

  Route::get('/staffs', 'LMS\StaffController@index')->name('staffs');

  Route::get('/otp', 'dashboard\UserController@otp')->name('otp-list');

  Route::resource('categories', CourseCategoryController::class)->names('courses.categories');
  Route::resource('subcategories', CourseSubCategoryController::class)->names('courses.subcategories');
  Route::resource('courses', CourseController::class)->names('courses');
  Route::resource('classes', CourseClassController::class)->names('classes');
  Route::resource('livestreams', LivestreamClassController::class)->names('livestreams');
  Route::resource('class-permissions', CourseClassPermissionController::class);


  Route::resource('webinars', WebinarController::class);
  Route::get('webinars/start', 'dashboard\UserController@otp')->name('webinars.start');
  Route::get('webinars/{webinar}/registrations/download-csv', [WebinarController::class, 'downloadCsv'])
    ->name('admin.webinars.registrations.download-csv');

  Route::get('/log-file', function () {
    $logPath = storage_path('logs/laravel.log');

    if (!File::exists($logPath)) {
      return Response::make('Log file not found.', 404);
    }

    $logContent = File::get($logPath);

    // Button to clear the log
    $clearButton = '<a href="/clear-log" style="position: fixed; top: 10px; right: 10px; padding: 10px; background: red; color: white; text-decoration: none; border-radius: 5px;">Clear Log File</a>';

    // Combine button and log content
    $responseContent = $clearButton . '<pre>' . e($logContent) . '</pre>';

    return Response::make($responseContent, 200);
  });

  Route::get('/clear-log', function () {
    $logPath = storage_path('logs/laravel.log');
    File::put($logPath, ''); // Overwrites the file with empty content
    return redirect('/log-file')->with('status', 'Log file cleared!');
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
