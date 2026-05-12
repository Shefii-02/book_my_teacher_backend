<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPaymentTransfer extends Model
{
    protected $fillable = [
        'teacher_id',
        'transfer_no',
        'amount',
        'charge_amount',
        'final_amount',
        'transfer_method',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'upi_id',
        'status',
        'approved_by',
        'reference_no',
        'remarks',
        'requested_at',
        'processed_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
