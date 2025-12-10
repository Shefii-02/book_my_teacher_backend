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
        return $this->belongsTo(User::class, 'user_id');
    }

    // Teacher related to the review
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Subject course if any
    public function subjectCourse()
    {
        return $this->belongsTo(SubjectCourse::class, 'subject_course_id');
    }
}
