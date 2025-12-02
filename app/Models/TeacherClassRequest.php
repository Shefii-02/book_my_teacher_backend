<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClassRequest extends Model
{
    protected $fillable = [
        'teacher_id','type','selected_items','class_type','days_needed','notes','user_id','company_id','status'
    ];
}
