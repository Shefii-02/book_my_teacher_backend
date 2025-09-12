<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivestreamClassPermission extends Model
{
  protected $fillable = ['class_id', 'status', 'room_id'];

  public function class()
  {
    return $this->belongsTo(CourseClass::class, 'class_id');
  }
  public function teachers()
  {
    return $this->belongsToMany(User::class, 'livestream_class_teacher', 'livestream_id', 'teacher_id')->withPivot('is_host');
  }
}
