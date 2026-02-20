<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralRequest extends Model
{
  protected $fillable = [
    'from_location',
    'grade',
    'board',
    'subject',
    'note',
    'user_id',
    'company_id',
    'status'
  ];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }

  // Status Label Accessor
  public function getStatusBadgeAttribute()
  {
    return match ($this->status) {
      'pending' => '<span class="badge bg-warning">Pending</span>',
      'demo_scheduled' => '<span class="badge bg-info">Demo Scheduled</span>',
      'converted_to_admission' => '<span class="badge bg-success">Converted</span>',
      'closed' => '<span class="badge bg-danger">Closed</span>',
      default => '<span class="badge bg-secondary">Unknown</span>',
    };
  }
}
