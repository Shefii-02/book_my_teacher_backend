<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
  protected $fillable = [
    'course_id', 'title', 'description', 'type', 'scheduled_at', 'teacher_id',
    'start_time','end_time','class_mode','meeting_link',
    'meeting_id','meeting_password','is_recording_available',
    'recording_url','priority','status'
  ];

  public function course_data()
  {
    return $this->hasOne(Course::class,'id','course_id');
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
