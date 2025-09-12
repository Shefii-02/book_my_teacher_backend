<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
  protected $fillable = ['title', 'description', 'thumbnail', 'company_id', 'created_by'];

  public function subCategories()
  {
    return $this->hasMany(CourseSubCategory::class, 'category_id');
  }

  public function courses()
  {
    return $this->hasMany(Course::class, 'category_id');
  }

  public function creator()
  {
    return $this->hasOne(User::class, 'id', 'created_by');
  }
}
