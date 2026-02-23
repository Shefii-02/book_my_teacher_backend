<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BannerRequest extends Model
{
      use SoftDeletes;


  protected $fillable = ['banner_id', 'user_id', 'company_id', 'status','notes'];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
  public function banner(){
        return $this->hasOne(TopBanner::class, 'id', 'banner_id');
  }

    // Status Label Accessor
  public function getStatusBadgeAttribute()
  {
    return match ($this->status) {
      'pending' => '<span class="badge bg-warning">Pending</span>',
      'not_connected' => '<span class="badge bg-warning">Not Connected</span>',
      'call_back_later' => '<span class="badge bg-warning">Call back Later</span>',
      'follow_up_later' => '<span class="badge bg-warning">Follow up Later</span>',
      'demo_scheduled' => '<span class="badge bg-warning">Scheduled</span>',
      'converted_to_admission' => '<span class="badge bg-success">Converted</span>',
      'closed' => '<span class="badge bg-danger">Closed</span>',
      default => '<span class="badge bg-secondary">Unknown</span>',
    };
  }
}
