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
  ->withMiddleware(function (Middleware $middleware) {

  })->withSchedule(function (Schedule $schedule) {
    //
      $schedule->command('queue:work --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();
  })
  ->withExceptions(function (Exceptions $exceptions) {
    Log::info('start');
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
          Log::info('end');
    });
  })->create();
