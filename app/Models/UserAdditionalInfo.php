<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdditionalInfo extends Model
{
    protected $table = 'user_additional_info';

    protected $fillable = [
        'user_id',
        'key_title',
        'key_value',
        'company_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
