<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPaymentSetting extends Model
{
    protected $fillable = [
        'company_id', 'gateway_name', 'merchant_id', 'api_key', 'api_secret',
        'salt_key', 'salt_index', 'webhook_secret', 'is_active', 'mode'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
