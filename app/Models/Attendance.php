<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  //

  protected $fillable = ['course_id',	'class_id',	'student_id',	'marked_by',	'attendance_date',	'status'];

  public function classes()
  {
    return $this->hasOne(CourseClass::class, 'id', 'class_id');
  }

  public function user()
{
    return $this->belongsTo(User::class,'student_id');
}
}
