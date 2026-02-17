<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
  protected $fillable = [
    'course_id',
    'title',
    'description',
    'type',
    'scheduled_at',
    'start_time',
    'end_time',
    'class_mode',
    'meeting_link',
    'meeting_id',
    'meeting_password',
    'is_recording_available',
    'recording_url',
    'priority',
    'status',
    'created_by',
    'updated_by'
  ];


  public function scopeWithMeetingLink($query)
  {
    return $query->whereNotNull('meeting_link')
      ->where('meeting_link', '!=', '');
  }


  public function course_data()
  {
    return $this->hasOne(Course::class, 'id', 'course_id');
  }

  public function teachers()
  {
    return $this->belongsToMany(
      Teacher::class,     // related model
      'teacher_classes',  // pivot table
      'class_id',         // foreign key in pivot (points to CourseClass)
      'teacher_id'        // foreign key in pivot (points to Teacher)
    );
  }


  public function durationAnalytics()
  {
    return $this->hasOne(SpendTimeClassAnalytics::class, 'class_id');
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
