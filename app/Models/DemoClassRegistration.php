<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoClassRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id','user_id','name','email','phone','checked_in','attended_status',
    ];

    public function demoClass()
    {
        return $this->belongsTo(DemoClass::class);
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
