<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopBanner extends Model
{
    protected $fillable = [
        'title', 'description', 'thumb_id', 'main_id',
        'priority', 'banner_type', 'ct_label', 'ct_action',
        'company_id', 'status'
    ];

    protected $casts = [
    //     'is_booked' => 'boolean',
    //     'is_joined' => 'boolean',
        'status' => 'boolean',
    //     'booked_at' => 'datetime',
    //     'joined_at' => 'datetime',
    ];


  public function thumbnailMedia()
  {
    return $this->belongsTo(MediaFile::class, 'thumb_id');
  }

  public function mainImageMedia()
  {
    return $this->belongsTo(MediaFile::class, 'main_id');
  }

  public function getThumbnailUrlAttribute()
  {
    return $this->thumbnailMedia ? asset('storage/' . $this->thumbnailMedia->file_path) : null;
  }

  public function getMainImageUrlAttribute()
  {
    return $this->mainImageMedia ? asset('storage/' . $this->mainImageMedia->file_path) : null;
  }


  public function requestBanner()
  {
    return $this->hasOne(BannerRequest::class, 'banner_id','id');
  }


}
