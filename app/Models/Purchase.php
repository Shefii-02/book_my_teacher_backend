<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    protected $fillable = [
        'student_id','course_id','coupon_code','price','discount_amount','tax_amount','grand_total',
        'is_installment','installments_count','installment_interval_months','installment_additional_amount',
        'notes','status','created_by','tax_included','tax_percent','payment_method','payment_source'
    ];

    public function student(): BelongsTo { return $this->belongsTo(User::class); }
    public function course(): BelongsTo { return $this->belongsTo(Course::class); }
    public function installments(): HasMany { return $this->hasMany(PurchaseInstallment::class); }
    public function payments(): HasOne { return $this->hasOne(PurchasePayment::class); }
}
