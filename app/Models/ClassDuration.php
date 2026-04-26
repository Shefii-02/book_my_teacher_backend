<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassDuration extends Model
{
    protected $fillable = [
        'class_id',
        'course_id',
        'started_at',
        'ended_at',
        'duration',
        'actual_duration',
        'extra_minutes',
        'note',
        'verified_by',
        'verified_at',
        'status'
    ];
}
