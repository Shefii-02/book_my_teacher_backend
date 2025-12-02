<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class BannerRequest extends Model
{
    protected $fillable = ['banner_id','user_id','company_id'];
}
