<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
  use HasFactory;


  protected $fillable = [
    'user_id',
    'mime_type',
    'company_id',
    'file_type',
    'file_path',
    'name',
  ];
}
