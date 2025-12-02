<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubjectReview extends Model
{
    protected $fillable = ['subject_id','user_id','subject_course_id','comments','rating'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
