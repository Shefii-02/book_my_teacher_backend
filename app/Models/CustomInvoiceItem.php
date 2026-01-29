<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CustomInvoiceItem extends Model
{
    protected $fillable = [
        'custom_invoice_id',
        'title',
        'quantity',
        'price',
        'total',
    ];
}
