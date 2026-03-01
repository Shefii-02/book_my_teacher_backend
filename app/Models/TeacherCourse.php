<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
  protected $fillable = [
    'teacher_id',
    'course_id'
  ];

  public function courses()
  {
    return $this->hasOne(Course::class, 'id', 'course_id');
  }

  public function course()
  {
    return $this->hasOne(Course::class, 'id', 'course_id');
  }



  public function teacher()
  {
    return $this->hasOne(Teacher::class, 'id', 'teacher_id');
  }
}
