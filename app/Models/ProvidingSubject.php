<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvidingSubject extends Model
{
    protected $fillable = [
        'company_id',
        'subject_id',
        'position'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
