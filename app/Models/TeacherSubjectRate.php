<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjectRate extends Model
{
    protected $fillable = [
        'teacher_id','subject_id','rate_0_10','rate_10_30','rate_30_plus'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->hasOne(\App\Models\Subject::class,'id','subject_id');
    }
}
