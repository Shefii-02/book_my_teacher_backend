<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {$middleware->alias([
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            // 'XSS' => \App\Http\Middleware\XSS::class,
            // 'revalidate' => \App\Http\Middleware\RevalidateBackHistory::class,
            'admin_panel' => \App\Http\Middleware\AdminPanel::class,
            'company_panel' => \App\Http\Middleware\CompanyPanel::class,
            'teacher_panel' => \App\Http\Middleware\TeacherPanel::class,
            // 'owner_panel' => \App\Http\Middleware\OwnerPanel::class,
            // 'maintainer_panel' => \App\Http\Middleware\MaintainerPanel::class,
            // 'check.plan.expiry' => \App\Http\Middleware\CheckPlanExpiry::class,

        ]);

  })->withSchedule(function (Schedule $schedule) {
    //
      $schedule->command('queue:work --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();
  })
  ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->report(function (Throwable $exception) {
      // if (!env('APP_DEBUG')) {
      $content['message'] = $exception->getMessage();
      $content['file'] = $exception->getFile();
      $content['line'] = $exception->getLine();
      $content['trace'] = $exception->getTrace();

      $content['url'] = request()->url();
      $content['body'] = request()->all();
      $content['ip'] = request()->ip();
      \App\Emails::sendError($content);
      // }
    });
  })->create();
