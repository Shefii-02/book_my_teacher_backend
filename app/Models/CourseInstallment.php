<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseInstallment extends Model
{
    protected $fillable = ['student_course_id','due_date','amount','paid_amount','is_paid','payment_ref'];

    public function studentCourse(): BelongsTo { return $this->belongsTo(StudentCourse::class); }
}
