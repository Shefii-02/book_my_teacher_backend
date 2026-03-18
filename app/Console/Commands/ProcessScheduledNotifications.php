<?php
namespace App\Console\Commands;

use App\Jobs\ProcessScheduledNotificationsJob;
use Illuminate\Console\Command;

class ProcessScheduledNotifications extends Command
{
    protected $signature   = 'notifications:process';
    protected $description = 'Process and send scheduled notifications';

    public function handle(): void
    {
        $this->info('Processing scheduled notifications...');
        ProcessScheduledNotificationsJob::dispatch();
        $this->info('✅ Job dispatched successfully');
    }
}
