<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{

 protected $fillable = [
        'user_id',
        'status',
        'rating',
        'feedback',
        'show_dispaly',
    ];

}
