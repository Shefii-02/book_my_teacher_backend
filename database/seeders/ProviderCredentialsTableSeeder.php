<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderCredentialsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('provider_credentials')->insert([
            [
                'stream_provider_id' => 1, // ZEGOCLOUD
                'app_id' => '1234567890',
                'app_sign' => 'zego_fake_app_sign_1234567890',
                'server_secret' => 'zego_fake_server_secret_123456',
                'api_key' => null,
                'api_secret' => null,
                'extra_config' => json_encode(['region' => 'global']),
            ],
            [
                'stream_provider_id' => 2, // Agora
                'app_id' => 'abcdef123456',
                'app_sign' => null,
                'server_secret' => null,
                'api_key' => 'agora_fake_api_key',
                'api_secret' => 'agora_fake_api_secret',
                'extra_config' => json_encode(['region' => 'asia']),
            ],
            [
                'stream_provider_id' => 3, // VideoSDK
                'app_id' => 'videosdk_project_id',
                'app_sign' => null,
                'server_secret' => 'videosdk_server_secret',
                'api_key' => null,
                'api_secret' => null,
                'extra_config' => json_encode(['plan' => 'starter']),
            ],
            [
                'stream_provider_id' => 4, // YouTube Live
                'app_id' => null,
                'app_sign' => null,
                'server_secret' => null,
                'api_key' => 'youtube_api_key',
                'api_secret' => null,
                'extra_config' => json_encode(['channel_id' => 'UC1234567890']),
            ],
            [
                'stream_provider_id' => 5, // Custom RTMP
                'app_id' => null,
                'app_sign' => null,
                'server_secret' => null,
                'api_key' => null,
                'api_secret' => null,
                'extra_config' => json_encode(['rtmp_url' => 'rtmp://live.example.com/app']),
            ],
        ]);
    }
}
