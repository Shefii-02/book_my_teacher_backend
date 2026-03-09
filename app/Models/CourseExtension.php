<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseExtension extends Model
{

  public function enrollment()
  {
    return $this->belongsTo(CourseEnrollment::class, 'course_enrollment_id');
  }
}
