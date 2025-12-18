<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseInstallment extends Model
{
    protected $table = 'purchase_installments';
    protected $fillable = ['purchase_id','due_date','amount','paid_amount','is_paid','payment_method','payment_source','paid_by','paid_date'];
    public function purchase(): BelongsTo { return $this->belongsTo(Purchase::class); }
}
