<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationRecipient extends Model
{
    protected $fillable = [
        'notification_id', 'user_id',
        'is_read', 'is_push_sent', 'is_push_failed',
        'push_error', 'read_at', 'push_sent_at',
    ];

    protected $casts = [
        'is_read'        => 'boolean',
        'is_push_sent'   => 'boolean',
        'is_push_failed' => 'boolean',
        'read_at'        => 'datetime',
        'push_sent_at'   => 'datetime',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =============================================
    // SCOPES
    // =============================================
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeFailed($query)
    {
        return $query->where('is_push_failed', true);
    }
}
