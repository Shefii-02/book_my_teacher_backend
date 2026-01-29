<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class CustomInvoice extends Model
{
  use HasFactory;
  protected $fillable = [
    'invoice_no',
    'user_id',
    'customer_name',
    'customer_email',
    'customer_mobile',
    'customer_address',
    'subtotal',
    'discount',
    'tax_percent',
    'tax_amount',
    'grand_total',
    'status',
    'invoice_date',
  ];

  public function items()
  {
    return $this->hasMany(CustomInvoiceItem::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
