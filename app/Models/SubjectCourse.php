<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectCourse extends Model
{
    protected $fillable = ['subject_id','title','description','main_image'];
}
