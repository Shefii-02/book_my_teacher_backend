<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
  protected $fillable = ['course_id', 'title', 'description', 'type', 'scheduled_at', 'teacher_id'];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
  public function teacher()
  {
    return $this->belongsTo(User::class, 'teacher_id');
  }
  public function livestream()
  {
    return $this->hasOne(LivestreamClass::class, 'class_id');
  }
  public function permissions()
  {
    return $this->hasOne(CourseClassPermission::class, 'class_id');
  }
}
