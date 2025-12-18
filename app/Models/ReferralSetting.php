<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralSetting extends Model
{
    protected $fillable = [
        'reward_per_join',
        'bonus_on_first_class',
        'how_it_works',
        'how_it_works_description',
        'badge_title',
        'badge_description',
        'share_link_description',
    ];
}
