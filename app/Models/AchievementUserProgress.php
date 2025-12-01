<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementUserProgress extends Model
{
    protected $table = 'achievement_user_progress';

    protected $fillable = ['user_id','task_id','current_value','completed','completed_at'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function task()
    {
        return $this->belongsTo(AchievementTask::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
