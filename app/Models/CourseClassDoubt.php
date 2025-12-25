<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClassDoubt extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'doubt',
        'reply',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
