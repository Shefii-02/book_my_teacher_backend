<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerRequest extends Model
{
  protected $fillable = ['banner_id', 'user_id', 'company_id', 'status'];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function banner(){
        return $this->hasOne(TopBanner::class, 'id', 'banner_id');
  }
}
