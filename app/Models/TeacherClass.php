<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
  protected $fillable = [
    'teacher_id',
    'class_id'
  ];

  // public function courses()
  // {
  //   return $this->hasOne(Course::class, 'id', 'course_id');
  // }

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

  public function courses()
  {
    return $this->belongsToMany(
      Course::class,
      'teacher_classes',
      'id', // Pivot column referencing Teacher
      'course_id',  // Pivot column referencing Course
      'id',         // Local key on Teacher table
      'id'          // Local key on Course table
    );
  }
}
