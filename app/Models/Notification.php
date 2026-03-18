<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'body', 'type', 'category', 'action_type',
        'notifiable_type', 'notifiable_id',
        'target_type', 'target_role', 'target_user_ids',
        'screen', 'screen_id', 'extra_data',
        'sent_count', 'read_count', 'failed_count',
        'created_by', 'scheduled_at', 'sent_at',
    ];

    protected $casts = [
        'target_user_ids' => 'array',
        'extra_data'      => 'array',
        'scheduled_at'    => 'datetime',
        'sent_at'         => 'datetime',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================
    public function recipients(): HasMany
    {
        return $this->hasMany(NotificationRecipient::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    // =============================================
    // SCOPES
    // =============================================
    public function scopePending($query)
    {
        return $query->whereNull('sent_at')
                     ->where('scheduled_at', '<=', now());
    }

    public function scopeScheduled($query)
    {
        return $query->whereNull('sent_at')
                     ->where('scheduled_at', '>', now());
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    // =============================================
    // ACCESSORS
    // =============================================
    public function getIsScheduledAttribute(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isFuture();
    }

    public function getIsSentAttribute(): bool
    {
        return !is_null($this->sent_at);
    }
}
