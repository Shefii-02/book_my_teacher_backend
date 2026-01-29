<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
  protected $table = "course_categories";

  protected $fillable = ['title', 'description', 'thumbnail', 'company_id', 'created_by', 'status', 'position'];

  public function subCategories()
  {
    return $this->hasMany(CourseSubCategory::class, 'category_id');
  }

  // public function courses()
  // {
  //   return $this->hasMany(Course::class, 'category_id');
  // }

   public function courses()
  {
    return $this->belongsToMany(
      Course::class,
      'course_category',   // pivot table
      'course_id',         // foreign key on pivot (for Course)
      'course_id'         // related key on pivot (for Teacher)
    );
  }

  public function creator()
  {
    return $this->hasOne(User::class, 'id', 'created_by');
  }

  public function thumbnailMedia()
  {
    return $this->belongsTo(MediaFile::class, 'thumbnail');
  }


  public function getThumbnailUrlAttribute()
  {
    return $this->thumbnailMedia ? asset('storage/' . $this->thumbnailMedia->file_path) : null;
  }


}
