<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopTeacher extends Model
{
    protected $fillable = ['teacher_id', 'position'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
