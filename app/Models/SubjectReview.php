<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectReview extends Model
{
  use HasFactory;

  protected $table = 'subject_reviews';

  /**
   * Mass assignable attributes
   */
  protected $fillable = [
    'subject_id',
    'user_id',
    'teacher_id',
    'subject_course_id',
    'comments',
    'rating'
  ];

  /**
   * Relationships
   */

  // Subject of the review
  public function subject()
  {
    return $this->belongsTo(Subject::class, 'subject_id');
  }

  // User who wrote the review
  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }

  // Teacher related to the review
  public function teacher()
  {
    return $this->hasOne(Teacher::class, 'id', 'teacher_id');
  }

  // Subject course if any
  public function course()
  {
    return $this->belongsTo(Course::class, 'course_id');
  }
}
