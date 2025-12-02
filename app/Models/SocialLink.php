<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = [
        'company_id', 'name', 'icon', 'link', 'type'
    ];
}
