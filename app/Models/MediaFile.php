<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
  use HasFactory;


  protected $fillable = [
    'teacher_id',
    'mime_type',
    'company_id',
    'file_category',
    'file_path',
    'name',
  ];
}
