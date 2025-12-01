<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCertificate extends Model
{
  protected $table = 'teacher_certificates';
  protected $guarded = [];

  protected $primaryKey = 'id'; // change if needed

  public function teacher()
  {
    return $this->belongsTo(Teacher::class);
  }

  public function fileMedia()
  {
    return $this->belongsTo(MediaFile::class, 'file_id', 'id');
  }

  public function getFileUrlAttribute()
  {
    return $this->fileMedia?->file_path;
  }
}
