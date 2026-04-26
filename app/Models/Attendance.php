<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  //

  public function classes()
  {
    return $this->hasOne(CourseClass::class, 'id', 'class_id');
  }

  public function user()
{
    return $this->belongsTo(User::class,'student_id');
}
}
