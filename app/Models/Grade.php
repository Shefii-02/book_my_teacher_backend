<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
  use HasFactory;
  protected $fillable = [
    'thumb',
    'name',
    'value',
    'description',
    'position',
    'published',
    'company_id'
  ];


  public function thumbnailMedia()
  {
    return $this->belongsTo(MediaFile::class, 'thumb');
  }


  public function getThumbnailUrlAttribute()
  {
    return $this->thumbnailMedia ? asset('storage/' . $this->thumbnailMedia->file_path) : null;
  }

  public function boards()
  {
    return $this->belongsToMany(Board::class, 'board_grade');
  }



  public function category()
{
    return $this->hasOne(
        CourseCategory::class,
        'title', // CourseCategory column
        'name'   // Grade column
    )->where('company_id', auth()->user()->company_id);
}

}
