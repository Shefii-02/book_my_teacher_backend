<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementTask extends Model
{
    protected $fillable = ['achievement_level_id','task_type','title','description','target_value','points','position','is_active'];

    public function level()
    {
        return $this->belongsTo(AchievementLevel::class, 'achievement_level_id');
    }

    public function progress()
    {
        return $this->hasMany(AchievementUserProgress::class, 'task_id');
    }
}
