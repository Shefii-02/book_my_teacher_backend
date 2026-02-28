<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachersTeachingGradeDetail extends Model
{
  use HasFactory;

  protected $fillable = [
   'user_id',	'grade_id',	'board_id',	'subject_id',	'online',	'offline'

  ];


}
