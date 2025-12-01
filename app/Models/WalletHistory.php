<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
  protected $fillable = ['user_id', 'wallet_type', 'title', 'type', 'amount', 'status', 'date', 'notes'];

  public function transactions()
  {
    return $this->hasMany(WalletTransaction::class);
  }
  public function user()
  {
    return $this->belongsTo(\App\Models\User::class);
  }
}
