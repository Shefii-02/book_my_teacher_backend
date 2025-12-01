<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementLevel extends Model
{
    protected $fillable = ['role','level_number','title','description','is_active','position','company_id'];

    public function tasks()
    {
        return $this->hasMany(AchievementTask::class, 'achievement_level_id')->orderBy('position');
    }

    public function userLevels()
    {
        return $this->hasMany(AchievementUserLevel::class, 'level_id');
    }
}

// use App\Services\AchievementService;

// // when student signs up with teacher referral code
// AchievementService::updateProgress($teacherId, 'referral_count', 1);

// // when teacher uploads a new video
// AchievementService::updateProgress($teacherId, 'youtube_upload', 1);

// // when student attends class
// AchievementService::updateProgress($studentId, 'live_class_attend', 1);

