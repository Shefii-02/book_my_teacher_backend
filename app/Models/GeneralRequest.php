<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralRequest extends Model
{
  protected $fillable = [
    'from_location',
    'grade',
    'board',
    'subject',
    'note',
    'user_id',
    'company_id',
    'status'
  ];

  public function user()
  {
    return $this->hasOne(User::class, 'id', 'user_id');
  }
}
