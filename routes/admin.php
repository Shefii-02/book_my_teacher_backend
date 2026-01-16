<?php

use Illuminate\Support\Facades\Route;

//superadmin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => [
  'auth',
  'admin_panel',
  // 'XSS',        // Custom middleware for XSS prevention
  // 'revalidate', // Prevents back button after logout
], 'namespace' => 'App\Http\Controllers\SuperAdmin'], function () {
  Route::get('/', 'DashboardController@index')->name('index');
  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::get('/', 'DashboardController@index')->name('dashboard.index');
  Route::resource('companies', 'CompanyController')->names('companies');
});


