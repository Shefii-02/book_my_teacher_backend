<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
       protected $fillable = [
        'icon',
        'name',
        'value',
        'color_code',
        'difficulty_level',
        'position',
        'published'
    ];



  public function iconMedia()
  {
    return $this->belongsTo(MediaFile::class, 'icon');
  }


  public function getIconUrlAttribute()
  {
    return $this->iconMedia ? asset('storage/' . $this->iconMedia->file_path) : null;
  }


  public function boards()
{
    return $this->belongsToMany(Board::class, 'board_subject');
}



  public function providingSubjects()
{
    return $this->hasOne(ProvidingSubject::class);
}



}
