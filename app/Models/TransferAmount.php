<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferAmount extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
        'transfer_amount',
        'transaction_source',
        'transaction_method',
        'transfer_to_account_no',
        'transfer_to_ifsc_no',
        'transfer_holder_name',
        'transfer_upi_id',
        'transfer_upi_number',
        'transferred_by',
        'approved_at',
        'approved_by',
        'status',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
