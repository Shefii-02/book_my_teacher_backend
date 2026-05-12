<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachersTeachingGradeDetail extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'grade_id',
    'board_id',
    'subject_id',
    'online',
    'offline'

  ];


    protected $guarded = [];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }


  public function teacher()
  {
    return $this->belongsTo(Teacher::class,'user_id','user_id');
  }

}
