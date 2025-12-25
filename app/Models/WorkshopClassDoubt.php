<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopClassDoubt extends Model
{
    protected $fillable = [
        'user_id',
        'doubt',
        'class_id',
        'reply',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
