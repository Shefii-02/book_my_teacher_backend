<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class LoginActivity extends Model
{
    //
     use HasFactory;

    protected $fillable = ['user_id','provider','source','email','ip_address','user_agent','logged_in_at','company_id'];








}
