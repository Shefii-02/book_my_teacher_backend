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

Route::group(['namespace' => 'App\Http\Controllers'], function () {
  // authentication
  Route::get('/', 'auth\LoginController@index')->name('login');
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



//superadmin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth'], 'namespace' => 'App\Http\Controllers\SuperAdmin'], function () {
  Route::get('/', 'DashboardController@index')->name('index');
  Route::get('/', 'DashboardController@index')->name('dashboard');
  Route::get('/', 'DashboardController@index')->name('dashboard.index');
  Route::resource('companies', 'CompanyController')->names('companies');
});



Route::group(['prefix' => 'company', 'as' => 'company.', 'middleware' => ['auth'], 'namespace' => 'App\Http\Controllers'], function () {

  Route::get('/ajax/users/search', 'UserController@searchUsers')->name('search-users');
  Route::get('/users/{id}/courses', 'UserController@courses');
  Route::get('/courses/{id}/subjects', 'CourseController@subjects');
  Route::get('/courses/{id}/teachers', 'CourseController@teachers');




  Route::group(['prefix' => 'app', 'as' => 'app.', 'namespace' => 'MobileApp'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/', 'DashboardController@index')->name('index');

    Route::resource('top-banners', 'BannerController')->names('top-banners');
    Route::resource('course-banners', 'CourseBannerController')->names('course-banners');
    Route::resource('top-teachers', 'TopTeacherController')->names('top-teachers');
    Route::resource('teachers', 'TeacherController')->names('teachers');

    Route::resource('grades', 'Academic\GradeController')->names('grades');
    Route::get('subjects/setup', 'Academic\SubjectController@setup')->name('providing.setup');
    Route::post('subjects/reorder', 'Academic\SubjectController@reorder')->name('providing.reorder');
    Route::post('subjects/toggle', 'Academic\SubjectController@toggle')->name('providing.toggle');
    Route::resource('subjects', 'Academic\SubjectController')->names('subjects');

    Route::resource('boards', 'Academic\BoardController')->names('boards');
    Route::get('wallets/adjust', 'WalletController@adjustForm')->name('wallets.adjust');
    Route::get('wallets/transations', 'WalletController@transationsIndex')->name('wallets.transations');
    Route::post('wallet/{history}/approve', 'WalletController@transationApprove')->name('wallets.approve');
    Route::post('wallet/{history}/rollback', 'WalletController@TransationRollback')->name('wallets.rollback');
    Route::post('wallets/adjust', 'WalletController@adjustStore')->name('wallets.adjust.store');
    Route::resource('wallets', 'WalletController')->names('wallets');
    Route::post('referral/{ref_id}/credited', 'ReferralController@pointApprove')->name('referral.credit');
    Route::resource('referral', 'ReferralController')->names('referral');
    Route::resource('reviews', 'SubjectReviewController')->names('reviews');
    Route::resource('community-links', 'CommunityLinkController')->names('community-links');
    // Route::resource('achivements', 'AchivementsController')->names('achivements');

    Route::get('referral-settings', 'ReferralSettingController@edit')->name('referral.edit');
    Route::put('referral-settings', 'ReferralSettingController@update')->name('referral.update');

    Route::prefix('transfer')->name('transfer.')->group(function () {
      Route::get('/', 'TransferAmountController@index')->name('index');
      Route::get('/create', 'TransferAmountController@create')->name('create');
      Route::post('/store', 'TransferAmountController@store')->name('store');
      Route::get('/edit/{id}', 'TransferAmountController@edit')->name('edit');
      Route::put('/update/{id}', 'TransferAmountController@update')->name('update');
      Route::post('/approve/{id}', 'TransferAmountController@approve')->name('approve');
      Route::delete('/delete/{id}', 'TransferAmountController@destroy')->name('delete');
    });


    Route::prefix('achievements')->name('achievements.')->group(function () {
      Route::get('/', 'AchievementLevelController@index')->name('index');
      Route::get('/create', 'AchievementLevelController@create')->name('create');
      Route::post('/', 'AchievementLevelController@store')->name('store');
      Route::get('/{achievementLevel}/edit', 'AchievementLevelController@edit')->name('edit');
      Route::put('/{achievementLevel}', 'AchievementLevelController@update')->name('update');
      Route::delete('/{achievementLevel}', 'AchievementLevelController@destroy')->name('destroy');

      // tasks
      Route::post('/{achievementLevel}/tasks', 'AchievementLevelController@storeTask')->name('tasks.store');
      Route::put('/tasks/{task}', 'AchievementLevelController@updateTask')->name('tasks.update');
      Route::delete('/tasks/{task}', 'AchievementLevelController@destroyTask')->name('tasks.destroy');
    });


    Route::get('delete-account-requests', 'UserController@index')->name('delete-accounts.index');
    Route::post('delete-account-requests/{id}/approve', 'UserController@approve')->name('delete_account_requests.approve');
    Route::post('delete-account-requests/{id}/reject', 'UserController@reject')->name('delete_account_requests.reject');




    Route::get('/deleted-users', 'UserController@deleted_accounts')
      ->name('delete_accounts.list');

    Route::post('/deleted-users/restore/{id}', 'UserController@restore')
      ->name('delete_accounts.restore');

    Route::resource('statistics-watch', 'StatisticsWatchController')->names('statistics-watch');
    Route::resource('statistics-spend', 'StatisticsSpendController')->names('statistics-spend');

    Route::post('/top-teachers/toggle', 'TopTeacherController@toggle');
    Route::post('/top-teachers/reorder', 'TopTeacherController@reorder');
  });



  // Main Page Route
  Route::get('/', 'dashboard\Analytics@index')->name('dashboard.index');
  Route::get('/dashboard', 'dashboard\Analytics@index')->name('dashboard');
  Route::get('/profile', 'dashboard\UserController@profile')->name('profile');

  Route::put('/profile', 'dashboard\UserController@update')->name('profile.update');
  Route::post('/profile', 'dashboard\UserController@changePassword')->name('profile.changePassword');

  Route::get('/teachers', 'LMS\TeacherController@index')->name('teachers');
  Route::get('/teachers/create', 'LMS\TeacherController@create')->name('teachers.create');
  Route::post('/teachers/store', 'LMS\TeacherController@store')->name('teachers.store');
  Route::get('teachers/export', 'LMS\TeacherController@exportTeachers')->name('teachers.export');
  Route::get('teachers/{id}', 'LMS\TeacherController@overview')->name('teachers.overview');   // Overview
  Route::get('teachers/{id}/edit', 'LMS\TeacherController@edit')->name('teachers.edit');
  Route::put('teachers/{id}/edit', 'LMS\TeacherController@update')->name('teachers.update');  // Edit
  Route::delete('teachers/{id}', 'LMS\TeacherController@delete')->name('teachers.destroy');  // Delete
  Route::get('teachers/{id}/login-security', 'LMS\TeacherController@loginSecurity')->name('teachers.login-security');
  Route::post('teachers/{id}/login-security', 'LMS\TeacherController@loginSecurityChange')->name('teachers.login-security.change');


  Route::get('/company-settings/{company_id}', 'LMS\CompanySettingController@index');
  Route::post('/company-settings/social', 'LMS\CompanySettingController@storeSocial');
  Route::post('/company-settings/contact', 'LMS\CompanySettingController@updateContact');

  Route::get('/students', 'LMS\StudentController@index')->name('students');
  Route::get('/students/create', 'LMS\StudentController@create')->name('students.create');
  Route::post('/students/store', 'LMS\StudentController@store')->name('students.store');
  Route::get('students/{id}', 'LMS\StudentController@overview')->name('students.overview');   // Overview
  Route::get('students/{id}/edit', 'LMS\StudentController@edit')->name('students.edit');
  Route::put('students/{id}/edit', 'LMS\StudentController@update')->name('students.update');  // Edit
  Route::delete('students/{id}', 'LMS\StudentController@delete')->name('students.destroy');  // Delete
  Route::get('students/{id}/login-security', 'LMS\StudentController@loginSecurity')->name('students.login-security');
  Route::post('students/{id}/login-security', 'LMS\StudentController@loginSecurityChange')->name('students.login-security.change');


  Route::resource('guest', GuestController::class)->names('guest');

  Route::resource('guest-teacher', GuestTeacherController::class);

  Route::get('guest/{id}/overview', [GuestController::class, 'overview'])
    ->name('guest.overview');
  Route::get('guest-teacher/{id}/overview', [GuestTeacherController::class, 'overview'])
    ->name('guest-teacher.overview');

  Route::get('/staffs', 'LMS\StaffController@index')->name('staffs');

  Route::get('/otp', 'dashboard\UserController@otp')->name('otp-list');
  Route::get('/otp/{id}/edit', 'dashboard\UserController@editOtp')->name('otp.edit');
  Route::put('/otp/{id}', 'dashboard\UserController@updateOtp')->name('otp.update');

  Route::resource('courses/categories', CourseCategoryController::class)->names('categories');
  Route::resource('courses/subcategories', CourseSubCategoryController::class)->names('subcategories');
  Route::get('/categories/{id}/subcategories', [CourseController::class, 'getSubcategories']);

  // /admin/courses/load-step-form/${step}?course_id=${courseId}
  Route::get('courses/load-step-form/{step}', [CourseController::class, 'loadStepForm'])->name('courses.load-step-form');
  Route::prefix('courses/{identity}')->group(function () {
    Route::resource('schedule-class', CourseClassController::class)
      ->names('courses.schedule-class');
    Route::resource('materials', CourseMaterialController::class)
      ->names('courses.materials');
  });

  Route::prefix('requests')->name('requests.')->group(function () {
    Route::get('form-class', 'RequestController@formClass')->name('form-class');
    Route::get('top-banner', 'RequestController@topBanner')->name('top-banner');
    Route::get('course-banner', 'RequestController@courseBanner')->name('course-banner');
    Route::get('teacher-class', 'RequestController@teacherClass')->name('teacher-class');
  });


  Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('init/{id}', 'LMS\PurchaseController@initPayment')->name('init');
    Route::get('invoice/download/{id}', 'LMS\AdmissionController@downloadInvoice')->name('invoice.download');
    Route::post('process/{id}', 'LMS\PurchaseController@paymentProcess')->name('process');
    Route::get('callback/{id}', 'LMS\PurchaseController@paymentCallback')->name('callback');
    Route::post('reject', 'LMS\PurchaseController@reject')->name('reject');
    Route::get('success/{id}', 'LMS\PurchaseController@successPage')->name('success');
    Route::get('/invoice/verify/{purchase}', 'LMS\PurchaseController@verify')->name('invoice.verify');
  });



  Route::get('/company/settings', 'LMS\CompanySettingController@index')
    ->name('company.settings');

  Route::post('/company-settings', 'LMS\CompanySettingController@companySettingsStore')
    ->name('company-settings-store');


  Route::post('/company/settings/general', 'LMS\CompanySettingController@updateGeneral')
    ->name('company.settings.general.update');

  Route::post('/company/settings/branding', 'LMS\CompanySettingController@updateBranding')
    ->name('company.settings.branding.update');

  Route::post('/company/settings/social', 'LMS\CompanySettingController@updateSocial')
    ->name('company.settings.social.update');

  Route::post('/company/settings/payment', 'LMS\CompanySettingController@updatePayment')
    ->name('company.settings.payment.update');

  Route::post('/company/settings/security', 'LMS\CompanySettingController@updateSecurity')
    ->name('company.settings.security.update');



  Route::resource('courses', CourseController::class)->names('courses');

  Route::get('coupons/trashed', [CouponController::class, 'trashed'])->name('coupons.trashed');
  Route::post('coupons/{id}/restore', [CouponController::class, 'restore'])->name('coupons.restore');


  Route::resource('coupons', CouponController::class);


  Route::get('admission', 'LMS\AdmissionController@index')->name('admissions.index');
  Route::get('admission/create', 'LMS\AdmissionController@create')->name('admissions.create');

  Route::post('admission/store', 'LMS\AdmissionController@admissionStore')->name('admissions.store');

  Route::get('admissions/student-search', 'LMS\AdmissionController@studentSearch')->name('admissions.student.search');
  Route::get('admissions/course-search', 'LMS\AdmissionController@courseSearch')->name('admissions.course.search');
  Route::get('admissions/course-info/{id}', 'LMS\AdmissionController@courseInfo')->name('admissions.course.info');
  Route::post('admissions/validate-coupon', 'LMS\AdmissionController@validateCoupon')->name('admissions.coupon.validate');



  // PhonePe callback (public endpoint - secure it)
  Route::post('admissions/payment/callback', 'LMS\AdmissionController@paymentCallback')->name('admin.admissions.payment.callback');
  Route::get('admissions/payment/success', 'LMS\AdmissionController@paymentSuccess')->name('admin.admissions.payment.success'); // optional redirect

  Route::get('course-swap', 'LMS\AcademicController@courseSwap')->name('course-swap.index');
  Route::post('course-swap/store', 'LMS\AcademicController@courseSwapStore')->name('course-swap.store');


  // Route::resource('schedule-class/{identity}', CourseClassController::class)->names('courses.schedule-class');
  Route::resource('livestreams', LivestreamClassController::class)->names('livestreams');
  Route::resource('class-permissions', CourseClassPermissionController::class);


  Route::resource('webinars', WebinarController::class);
  Route::get('webinars/start', 'dashboard\UserController@otp')->name('webinars.start');
  Route::get('webinars/{webinar}/registrations/download-csv', [WebinarController::class, 'downloadCsv'])
    ->name('webinars.registrations.download-csv');

  Route::resource('demo-classes', 'LMS\DemoClassController');
  // Route::get('demo-classes/{demo_class}/registrations', 'LMS\DemoClassController@registrations')->name('demo-classes.register');
  Route::get('demo-classes/{demo_class}/class/start', 'LMS\DemoClassController@registrationStore')->name('demo-classes.start');
  Route::get('demo-classes/{demo_class}/participant/create', 'LMS\DemoClassController@participantCreate')->name('demo-classes.participant.create');
  Route::post('demo-classes/{demo_class}/participant/store', 'LMS\DemoClassController@participantStore')->name('demo-classes.participant.store');
  Route::delete('demo-classes/{demo_class}/participant/{id}/delete', 'LMS\DemoClassController@participantDelete')->name('demo-classes.participant.delete');



  Route::resource('workshops', 'LMS\WorkshopController')->names('workshops');
  Route::prefix('workshops/{id}')->group(function () {
    Route::resource('schedule-class', 'LMS\WorkshopClassController')->names('workshops.schedule-class');
    Route::resource('materials', 'LMS\WorkshopMaterialController')->names('workshops.materials');
  });

  Route::get('workshops/start', 'dashboard\UserController@otp')->name('workshops.start');
  Route::get('workshops/{webinar}/registrations/download-csv', [WebinarController::class, 'downloadCsv'])
    ->name('workshops.registrations.download-csv');


  Route::resource('analytics', AnalyticController::class);



  Route::get('/log-file', function () {
    $logPath = storage_path('logs/laravel.log');

    if (!File::exists($logPath)) {
      return Response::make('Log file not found.', 404);
    }

    $logContent = File::get($logPath);

    // Button to clear the log
    $clearButton = '<a href="/company/clear-log" style="position: fixed; top: 10px; right: 10px; padding: 10px; background: red; color: white; text-decoration: none; border-radius: 5px;">Clear Log File</a>';

    // Combine button and log content
    $responseContent = $clearButton . '<pre>' . e($logContent) . '</pre>';

    return Response::make($responseContent, 200);
  });

  Route::get('/clear-log', function () {
    $logPath = storage_path('logs/laravel.log');
    File::put($logPath, ''); // Overwrites the file with empty content
    return redirect('/company/log-file')->with('status', 'Log file cleared!');
  });


  Route::group(['prefix' => 'hrms', 'as' => 'hrms.', 'middleware' => ['auth'], 'namespace' => 'HRMS'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('teams', TeamController::class)->names('teams');
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
