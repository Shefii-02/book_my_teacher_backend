<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppReview extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'status',
        'rating',
        'feedback',
        'position',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
