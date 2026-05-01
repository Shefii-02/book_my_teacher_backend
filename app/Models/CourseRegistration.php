<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
  use HasFactory;

  protected $fillable = [
    'course_id',
    'user_id',
    'name',
    'email',
    'phone',
    'checked_in',
    'company_id',
    'status'
  ];

  public function course()
  {
    return $this->belongsTo(Course::class);
  }

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }

  // Status Label Accessor
  public function getStatusBadgeAttribute()
  {
    return match ($this->status) {
      'PENDING' => '<span class="badge bg-warning">Pending</span>',
      'pending' => '<span class="badge bg-warning">Pending</span>',
      'NOT_CONNECTED' => '<span class="badge bg-warning">Not Connected</span>',
      'CALL_BACK_LATER' => '<span class="badge bg-warning">Call back Later</span>',
      'FOLLOW_UP_LATER' => '<span class="badge bg-warning">Follow up Later</span>',
      'DEMO_SCHEDULED' => '<span class="badge bg-warning">Scheduled</span>',
      'CONVERTED_TO_ADMISSION' => '<span class="badge bg-success">Converted</span>',
      'CLOSED' => '<span class="badge bg-danger">Closed</span>',
      default => '<span class="badge bg-secondary">Unknown</span>',
    };
  }
}
