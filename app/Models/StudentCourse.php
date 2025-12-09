<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentCourse extends Model
{
    protected $fillable = [
        'student_id','course_id','coupon_code','price','discount_amount','grand_total',
        'is_installment','installments_count','installment_interval_months','installment_additional_amount',
        'notes','status','created_by'
    ];

    public function student(): BelongsTo { return $this->belongsTo(User::class); }
    public function course(): BelongsTo { return $this->belongsTo(Course::class); }
    public function installments(): HasMany { return $this->hasMany(CourseInstallment::class); }
}
