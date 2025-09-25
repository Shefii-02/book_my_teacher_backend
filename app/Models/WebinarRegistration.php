<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'webinar_id','user_id','name','email','phone','checked_in','attended_status'
    ];

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }
}
