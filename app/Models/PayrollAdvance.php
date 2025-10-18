<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollAdvance extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'reason', 'date', 'is_deducted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
