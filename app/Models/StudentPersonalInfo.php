<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPersonalInfo extends Model
{
  use HasFactory;

  protected $table = "student_personal_info";
  protected $fillable = ['student_id', 'parent_email', 'parent_mobile', 'parent_name', 'parent_relation', 'current_eduction', 'study_mode'];
}
