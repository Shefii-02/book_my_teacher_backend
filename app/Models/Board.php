<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
  protected $fillable = ['icon', 'name', 'value', 'description', 'position', 'published','company_id'];


  public function grades()
  {
    return $this->belongsToMany(Grade::class, 'board_grade');
  }

  public function subjects()
  {
    return $this->belongsToMany(Subject::class, 'board_subject');
  }


   public function thumbnailMedia()
  {
    return $this->belongsTo(MediaFile::class, 'icon');
  }


  public function getIconUrlAttribute()
  {
    return $this->thumbnailMedia ? asset('storage/' . $this->thumbnailMedia->file_path) : null;
  }

}
