<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
  protected $fillable = [
    'thumb',
    'main',
    'name',
    'qualifications',
    'bio',
    'speaking_languages',
    'price_per_hour',
    'year_exp',
    'commission_enabled',
    'commission_percent',
    'demo_class_link',
    'certificates',
    'include_top_teachers',
    'subjects',
    'time_slots',
    'published',
    'company_id'
  ];

  protected $casts = [
    'speaking_languages' => 'array',
    'certificates'       => 'array',
    'subjects'           => 'array',
    'time_slots'         => 'array',
    'commission_enabled' => 'boolean',
    'include_top_teachers' => 'boolean',
    'published'          => 'boolean',
  ];

  public function subjectRates()
  {
    return $this->hasMany(TeacherSubjectRate::class);
  }


  public function teacherCertificates()
  {
    return $this->hasMany(\App\Models\TeacherCertificate::class,'teacher_id','id');
  }

  public function topTeacher()
{
    return $this->hasOne(TopTeacher::class);
}


  public function thumbnailMedia()
  {
    return $this->belongsTo(MediaFile::class, 'thumb');
  }

  public function mainImageMedia()
  {
    return $this->belongsTo(MediaFile::class, 'main');
  }

  public function getThumbnailUrlAttribute()
  {
    return $this->thumbnailMedia ? asset('storage/' . $this->thumbnailMedia->file_path) : null;
  }

  public function getMainImageUrlAttribute()
  {
    return $this->mainImageMedia ? asset('storage/' . $this->mainImageMedia->file_path) : null;
  }
}
