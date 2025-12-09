<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Coupon extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'company_id',
    'offer_name',
    'offer_code',
    'coupon_type',
    'discount_type',
    'discount_value',
    'discount_percentage',
    'max_discount',
    'start_date_time',
    'end_date_time',
    'is_unlimited',
    'minimum_order_value',
    'course_selection_type',
    'show_inside_courses',
    'max_usage_per_student',
    'is_unlimited_usage',
    'deleted_at',
  ];

  protected $casts = [
    'is_active' => 'boolean',
    'max_usage_count' => 'integer',
    'current_usage_count' => 'integer',
  ];


  public function courses()
  {
    return $this->belongsToMany(Course::class, 'coupon_course')->withTimestamps();
  }
}
