<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingSubject extends Model
{
  use HasFactory;
  protected $fillable = [
    'teacher_id',
    'subject'
  ];


  protected $table = 'teacher_subjects';
}
