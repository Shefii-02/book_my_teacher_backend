<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'type', 'balance', 'target'];

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
