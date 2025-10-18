<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfessionalInfo extends Model
{
  use HasFactory;

  protected $fillable = [
    'teacher_id',
    'profession',
    'ready_to_work',
    'teaching_mode',
    'offline_exp',
    'online_exp',
    'home_exp',
  ];


    protected $table = 'teacher_professional_info';
}
