<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'admission', 'course', 'webinar', 'workshop',
        'demo_class', 'invoice', 'reward', 'achievement',
        'transfer', 'spend_time', 'chat', 'custom',
        'push_enabled', 'in_app_enabled',
    ];

    protected $casts = [
        'admission'    => 'boolean',
        'course'       => 'boolean',
        'webinar'      => 'boolean',
        'workshop'     => 'boolean',
        'demo_class'   => 'boolean',
        'invoice'      => 'boolean',
        'reward'       => 'boolean',
        'achievement'  => 'boolean',
        'transfer'     => 'boolean',
        'spend_time'   => 'boolean',
        'chat'         => 'boolean',
        'custom'       => 'boolean',
        'push_enabled' => 'boolean',
        'in_app_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function allows(string $category): bool
    {
        return $this->$category ?? true;
    }
}
