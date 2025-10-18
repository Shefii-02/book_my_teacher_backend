<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'free_minutes_per_month',
        'max_participants',
        'supports_recording',
        'supports_chat',
        'supports_screen_share',
        'supports_audio_only',
        'supports_white_board',
        'billing_model',
        'is_active',
        'description',
    ];

    /**
     * Relationship: A stream provider has one set of credentials
     */
    public function credentials()
    {
        return $this->hasOne(ProviderCredential::class, 'stream_provider_id');
    }
}
