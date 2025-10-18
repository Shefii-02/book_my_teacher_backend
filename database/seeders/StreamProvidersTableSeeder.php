<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StreamProvidersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('stream_providers')->insert([
            [
                'name' => 'ZEGOCLOUD',
                'slug' => 'zegocloud',
                'type' => 'live_streaming',
                'free_minutes_per_month' => 10000,
                'max_participants' => 100,
                'supports_recording' => true,
                'supports_chat' => true,
                'supports_screen_share' => true,
                'supports_audio_only' => true,
                'supports_white_board' => true,
                'billing_model' => 'pay_as_you_go',
                'is_active' => true,
                'description' => 'ZEGOCLOUD provides live streaming, video conferencing, and real-time engagement features.'
            ],
            [
                'name' => 'Agora',
                'slug' => 'agora',
                'type' => 'live_streaming',
                'free_minutes_per_month' => 10000,
                'max_participants' => 200,
                'supports_recording' => true,
                'supports_chat' => true,
                'supports_screen_share' => true,
                'supports_audio_only' => true,
                'supports_white_board' => false,
                'billing_model' => 'pay_as_you_go',
                'is_active' => true,
                'description' => 'Agora provides real-time video/audio, interactive streaming, and engagement APIs.'
            ],
            [
                'name' => 'VideoSDK',
                'slug' => 'videosdk',
                'type' => 'live_streaming',
                'free_minutes_per_month' => 5000,
                'max_participants' => 50,
                'supports_recording' => true,
                'supports_chat' => true,
                'supports_screen_share' => true,
                'supports_audio_only' => true,
                'supports_white_board' => true,
                'billing_model' => 'subscription',
                'is_active' => true,
                'description' => 'VideoSDK offers APIs for video conferencing, live streaming, and collaborative apps.'
            ],
            [
                'name' => 'YouTube Live',
                'slug' => 'youtube',
                'type' => 'video_hosting',
                'free_minutes_per_month' => 0, // unlimited by design
                'max_participants' => null,   // viewer-based
                'supports_recording' => true,
                'supports_chat' => true,
                'supports_screen_share' => false,
                'supports_audio_only' => false,
                'supports_white_board' => false,
                'billing_model' => 'free',
                'is_active' => true,
                'description' => 'YouTube Live allows broadcasting live events with chat support and automatic recording.'
            ],
            [
                'name' => 'Custom RTMP',
                'slug' => 'rtmp',
                'type' => 'custom_rtmp',
                'free_minutes_per_month' => 0,
                'max_participants' => null,
                'supports_recording' => false,
                'supports_chat' => false,
                'supports_screen_share' => false,
                'supports_audio_only' => false,
                'supports_white_board' => false,
                'billing_model' => 'free',
                'is_active' => true,
                'description' => 'Custom RTMP server integration (e.g., OBS, Wowza, Nginx-RTMP).'
            ],
        ]);
    }
}
