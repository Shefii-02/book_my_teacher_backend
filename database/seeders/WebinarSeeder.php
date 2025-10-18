<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Webinar;
use App\Models\User;
use App\Models\StreamProvider;

class WebinarSeeder extends Seeder
{
    public function run()
    {
        $host = User::first() ?? User::factory()->create([
            'name' => 'Demo Host',
            'email' => 'host@example.com',
            'password' => bcrypt('password'),
        ]);

        $zego = StreamProvider::where('slug', 'zegocloud')->first();
        $agora = StreamProvider::where('slug', 'agora')->first();

        Webinar::create([
            'title' => 'ZEGOCLOUD Demo Webinar',
            'description' => 'A live webinar showcasing ZegoCloud integration.',
            'slug' => Str::slug('ZEGOCLOUD Demo Webinar'),
            'thumbnail_image' => '/uploads/webinars/zego-thumb.jpg',
            'main_image' => '/uploads/webinars/zego-banner.jpg',
            'host_id' => $host->id,
            'stream_provider_id' => $zego->id,
            'live_id' => 'zego-room-'.uniqid(),
            'started_at' => now()->addDays(1),
            'registration_end_at' => now()->addHours(20),
            'is_teacher_allowed' => true,
            'is_student_allowed' => true,
            'is_guest_allowed' => false,
            'max_participants' => 100,
            'is_record_enabled' => true,
            'is_chat_enabled' => true,
            'is_screen_share_enabled' => true,
            'status' => 'scheduled',
            'tags' => json_encode(['demo','zegocloud','education']),
            'company_id' => 1,
        ]);

        Webinar::create([
            'title' => 'Agora Introduction Class',
            'description' => 'An introductory class powered by Agora.',
            'slug' => Str::slug('Agora Introduction Class'),
            'thumbnail_image' => '/uploads/webinars/agora-thumb.jpg',
            'main_image' => '/uploads/webinars/agora-banner.jpg',
            'host_id' => $host->id,
            'stream_provider_id' => $agora->id,
            'live_id' => 'agora-room-'.uniqid(),
            'started_at' => now()->addDays(2),
            'registration_end_at' => now()->addDay(),
            'is_teacher_allowed' => true,
            'is_student_allowed' => true,
            'is_guest_allowed' => true,
            'max_participants' => 200,
            'is_record_enabled' => false,
            'is_chat_enabled' => true,
            'is_screen_share_enabled' => false,
            'status' => 'scheduled',
            'tags' => json_encode(['agora','intro','webinar']),
            'company_id' => 1,
        ]);
    }
}
