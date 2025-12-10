<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyIntegration extends Model
{
    protected $fillable = [
        'company_id', 'integration_name', 'config', 'is_active'
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
