<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'endpoint', 'method', 'headers', 'request_body', 'response_body',
        'status_code', 'user_id', 'ip_address', 'device_info'
    ];

    protected $casts = [
        'headers' => 'array',
        'request_body' => 'array',
        'response_body' => 'array',
    ];
}
