<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AchievementLevel;
use App\Models\AchievementTask;

class AchievementSeeder extends Seeder {
    public function run()
    {
        $l = AchievementLevel::create([
            'role'=>'teacher','level_number'=>1,'title'=>'Teacher - Beginner','description'=>'Level 1 tasks','position'=>1,'company_id' => 1
        ]);

        AchievementTask::create([
            'achievement_level_id'=>$l->id,
            'task_type'=>'referral_count','title'=>'Refer 10 students','target_value'=>10,'points'=>50
        ]);

        AchievementTask::create([
            'achievement_level_id'=>$l->id,
            'task_type'=>'youtube_upload','title'=>'Upload 3 Youtube videos','target_value'=>3,'points'=>30
        ]);
    }
}
