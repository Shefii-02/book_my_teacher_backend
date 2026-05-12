<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherEarning extends Model
{
    protected $fillable = [
        'teacher_id',
        'created_by',
        'type',
        'source_id',
        'amount',
        'status',
        'remarks',
        'earned_at',
        'title',
    ];

    protected $casts = [
        'earned_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
