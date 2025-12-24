<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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


  // Direct access to Subjects through TeacherSubjectRate
  public function selectedSubjects()
  {
    return $this->hasManyThrough(
      Subject::class,
      TeacherSubjectRate::class,
      'teacher_id',   // FK on teacher_subject_rates
      'id',           // FK on subjects table
      'id',           // local key on teachers
      'subject_id'    // local key on teacher_subject_rates
    );
  }



  public function teacherCertificates()
  {
    return $this->hasMany(\App\Models\TeacherCertificate::class, 'teacher_id', 'id');
  }

  public function topTeacher()
  {
    return $this->hasOne(TopTeacher::class);
  }


   public function user()
  {
    return $this->hasOne(User::class,'id','user_id');
  }

  public function reviews()
  {
    return $this->hasMany(SubjectReview::class, 'teacher_id', 'id');
  }

  public function courses()
  {
    return $this->hasMany(TeacherCourse::class, 'teacher_id', 'id');
  }


  public function classes()
  {
    return $this->belongsToMany(
      CourseClass::class,
      'teacher_classes',
      'teacher_id',
      'class_id'
    );
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
