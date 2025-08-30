<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfessionalInfo extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'profession',
    'ready_to_work',
    'experience',
    'offline_exp',
    'online_exp',
    'home_exp',
  ];
}
