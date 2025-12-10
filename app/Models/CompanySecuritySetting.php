<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySecuritySetting extends Model
{
    protected $fillable = [
        'company_id', 'two_factor_enabled', 'max_login_attempts',
        'lockout_minutes', 'allowed_ip_range', 'block_countries'
    ];

    protected $casts = [
        'two_factor_enabled' => 'boolean',
        'allowed_ip_range' => 'array',
        'block_countries' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
