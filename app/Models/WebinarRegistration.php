<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class WebinarRegistration extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected $fillable = [
    'webinar_id',
    'user_id',
    'name',
    'email',
    'phone',
    'checked_in',
    'attended_status',
  ];

  public function webinar()
  {
    return $this->belongsTo(Webinar::class);
  }

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
}
