<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisChatSubscriber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'chat:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    public function handle()
    {
        Redis::subscribe(['chat'], function ($message) {

            $data = json_decode($message, true);

            broadcast(new \App\Events\ChatEvent($data));
        });
    }
}
