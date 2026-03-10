<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
  protected $fillable = [
    'teacher_id',
    'class_id'
  ];

  public function courses()
  {
    return $this->hasOne(Course::class, 'id', 'course_id');
  }

  public function course()
  {
    return $this->hasOneThrough(
      Course::class,      // Final model
      CourseClass::class, // Intermediate model
      'id',               // Foreign key on course_classes (matches teacher_classes.class_id)
      'id',               // Foreign key on courses (matches course_classes.course_id)
      'class_id',         // Local key on teacher_classes
      'course_id'         // Local key on course_classes
    );
  }

  public function teacher()
  {
    return $this->hasOne(Teacher::class, 'id', 'teacher_id');
  }

  public function host()
  {
    return $this->hasOne(Teacher::class, 'id', 'teacher_id');
  }


  public function course_classes()
  {
    return $this->hasOne(CourseClass::class, 'id', 'class_id');
  }
}
