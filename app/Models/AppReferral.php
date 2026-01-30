<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppReferral extends Model
{
    //
    protected $fillable = [
        'referral_code',
        'device_hash',
        'ip',
        'ua',
        'first_visit',
        'last_visit',
        'applied',
        'applied_user_id',
        'ref_user_id',
        'status',
    ];

    protected $casts = [
        'first_visit' => 'datetime',
        'last_visit' => 'datetime',
        'applied' => 'boolean',
    ];


   public function user()
  {
    return $this->hasOne(User::class,'id','ref_user_id');
  }

   public function appliedUser()
  {
    return $this->hasOne(User::class,'id','applied_user_id');
  }


}
