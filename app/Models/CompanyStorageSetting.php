<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyStorageSetting extends Model
{
    protected $fillable = [
        'company_id', 'disk_type', 'bucket', 'access_key', 'secret_key',
        'region', 'folder_path', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
