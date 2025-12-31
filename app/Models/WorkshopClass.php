<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkshopClass extends Model
{
  protected $fillable = [
    'workshop_id',
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
    'status'
  ];

  protected $appends = [
    'start_date_time',
    'end_date_time',
  ];



  public function getStartDateTimeAttribute()
  {
    if (!$this->scheduled_at || !$this->start_time) {
      return null;
    }

    return Carbon::parse(
      $this->scheduled_at . ' ' . $this->start_time
    );
  }

  public function getEndDateTimeAttribute()
  {
    if (!$this->scheduled_at || !$this->end_time) {
      return null;
    }

    return Carbon::parse(
      $this->scheduled_at . ' ' . $this->end_time
    );
  }


  public function course_data()
  {
    return $this->hasOne(Course::class, 'id', 'course_id');
  }

  public function workshop()
  {
    return $this->hasOne(Workshop::class, 'id', 'workshop_id');
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
