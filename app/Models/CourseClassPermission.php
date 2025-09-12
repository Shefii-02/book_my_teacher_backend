<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClassPermission extends Model
{
    protected $fillable = [
        'class_id',
        'mode',
        'allow_voice',
        'allow_video',
        'allow_chat',
        'allow_screen_share'
    ];

    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }
}
