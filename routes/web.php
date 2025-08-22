<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers'], function () {
  // authentication
  Route::get('/', 'auth\LoginController@index')->name('login');
  Route::post('/', 'auth\LoginController@loginPost')->name('auth-login-post');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth'], 'namespace' => 'App\Http\Controllers'], function () {
  // Main Page Route
  Route::get('/', 'dashboard\Analytics@index');
  Route::get('/dashboard', 'dashboard\Analytics@index')->name('dashboard');
  Route::get('/teachers', 'LMS\TeacherController@index')->name('teachers');
  Route::get('/students', 'StudentController@index')->name('students');
  Route::get('/staffs', 'StaffController@index')->name('staffs');
});
