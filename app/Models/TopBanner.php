<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopBanner extends Model
{
  protected $fillable = [
    'title',
    'description',
    'thumb_id',
    'main_id',
    'priority',
    'banner_type',
    'ct_label',
    'ct_action',
    'company_id',
    'status',
    'type',
    'section_id'
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



  public function course()
  {
    return $this->belongsTo(Course::class, 'section_id');
  }

  public function workshop()
  {
    return $this->belongsTo(Workshop::class, 'section_id');
  }

  public function webinar()
  {
    return $this->belongsTo(Webinar::class, 'section_id');
  }


  public function requestBanner()
  {
    return $this->hasOne(BannerRequest::class, 'banner_id', 'id');
  }

  public function courseEntolled()
  {
    return $this->hasMany(CourseEnrollment::class, 'course_id', 'section_id');
  }

  public function courseRegistration()
  {
    return $this->hasMany(CourseRegistration::class, 'course_id', 'section_id');
  }

  public function webinarRegistration()
  {
    return $this->hasMany(WebinarRegistration::class, 'webinar_id', 'section_id');
  }

  public function workshopRegistration()
  {
    return $this->hasMany(WorkshopRegistration::class, 'workshop_id', 'section_id');
  }
}
