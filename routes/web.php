<?php

use Illuminate\Support\Facades\Route;


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


});



  Route::get('admin/webinar', function () {
    $app_id = 2342334234234;
    return view('company.webinar.index', compact('app_id'));
  });
