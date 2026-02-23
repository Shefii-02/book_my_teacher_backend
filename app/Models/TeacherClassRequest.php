<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherClassRequest extends Model
{
      use SoftDeletes;


  protected $fillable = [
    'teacher_id',
    'type',
    'selected_items',
    'class_type',
    'days_needed',
    'notes',
    'lead_notes',
    'user_id',
    'company_id',
    'status'
  ];

  public function teacher()
  {
    return $this->belongsTo(User::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

   public function getStatusBadgeAttribute()
  {
    return match ($this->status) {
      'pending' => '<span class="badge bg-warning">Pending</span>',
      'not_connected' => '<span class="badge bg-warning">Not Connected</span>',
      'call_back_later' => '<span class="badge bg-warning">Call back Later</span>',
      'follow_up_later' => '<span class="badge bg-warning">Follow up Later</span>',
      'demo_scheduled' => '<span class="badge bg-warning">Scheduled</span>',
      'converted_to_admission' => '<span class="badge bg-success">Converted</span>',
      'closed' => '<span class="badge bg-danger">Closed</span>',
      default => '<span class="badge bg-secondary">Unknown</span>',
    };
  }
}

