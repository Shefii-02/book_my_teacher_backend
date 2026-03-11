<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseEnrollment extends Model
{
  protected $fillable = [
    'company_id',
    'user_id',
    'course_id',
    'price',
    'discount',
    'final_price',
    'start_date',
    'expiry_date',
    'status',
    'payment_status',
    'suspended_at',
    'suspend_reason',
    'created_at',
    'updated_at',

  ];

  public function extensions()
  {
    return $this->hasMany(CourseExtension::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function course()
  {
    return $this->belongsTo(Course::class);
  }
}
