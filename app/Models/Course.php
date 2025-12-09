<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $fillable = [
    'thumbnail_id',
    'mainimage_id',
    'title',
    'description',
    'duration_type',
    'duration',
    'total_hours',
    'started_at',
    'ended_at',
    'actual_price',
    'discount_price',
    'discount_type',
    'discount_amount',
    'coupon_available',
    'net_price',
    'gross_price',
    'is_tax',
    'class_type',
    'has_material',
    'has_material_download',
    'class_mode',
    'has_exam',
    'is_counselling',
    'is_career_guidance',
    'company_id',
    'created_by',
    'type',
    'tax_percentage',
    'discount_validity',
    'discount_validity_end',
    'course_identity',
    'status',
    'step_completed',
    'course_type',
    'level',
    'commission_percentage',
    'institude_id',
  ];

  public function category()
  {
    return $this->belongsTo(CourseCategory::class);
  }
  // Course.php
  public function categories()
  {
    return $this->belongsToMany(CourseCategory::class, 'course_category')->withPivot('subcategories');
  }

  public function materials()
  {
    return $this->hasMany(CourseMaterial::class)->orderBy('position');
  }

  public function teachers()
  {
    return $this->belongsToMany(
      Teacher::class,
      'teacher_courses',   // pivot table
      'course_id',         // foreign key on pivot (for Course)
      'teacher_id'         // related key on pivot (for Teacher)
    );
  }



  public function teacherCourses()
  {
    return $this->hasMany(TeacherCourse::class);
  }


  public function subCategory()
  {
    return $this->belongsTo(CourseSubCategory::class);
  }
  public function classes()
  {
    return $this->hasMany(CourseClass::class, 'course_id')->orderBy('scheduled_at');
  }

  public function thumbnailMedia()
  {
    return $this->belongsTo(MediaFile::class, 'thumbnail_id');
  }

  public function mainImageMedia()
  {
    return $this->belongsTo(MediaFile::class, 'mainimage_id');
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
