<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasePayment extends Model
{
    protected $table = 'purchase_payments';
    protected $fillable = ['purchase_id','gateway','transaction_id','order_id','amount','currency','payload','status'];
    protected $casts = ['payload' => 'array'];
    public function purchase(): BelongsTo { return $this->belongsTo(Purchase::class); }
}
