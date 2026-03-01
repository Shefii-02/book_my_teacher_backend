<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherWorkingHour extends Model
{
  use HasFactory;
  protected $fillable = [
    'teacher_id',
    'available_day_id',
    'time_slot',
  ];




}
