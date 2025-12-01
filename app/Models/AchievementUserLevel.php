<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementUserLevel extends Model
{
    protected $table = 'achievement_user_levels';

    protected $fillable = ['user_id','level_id','is_completed','completed_at'];

    protected $casts = ['is_completed' => 'boolean'];

    public function level()
    {
        return $this->belongsTo(AchievementLevel::class, 'level_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
