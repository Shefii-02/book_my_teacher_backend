<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'stream_provider_id',
        'app_id',
        'app_sign',
        'server_secret',
        'api_key',
        'api_secret',
        'extra_config',
    ];

    protected $casts = [
        'extra_config' => 'array', // auto-cast JSON to array
    ];

    /**
     * Relationship: Credentials belong to a provider
     */
    public function provider()
    {
        return $this->belongsTo(StreamProvider::class, 'stream_provider_id');
    }
}
