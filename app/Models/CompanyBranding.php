<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBranding extends Model
{
protected $table ="company_branding";

    protected $fillable = [
        'company_id', 'theme_color', 'theme_secondary_color', 'sidebar_color',
        'navbar_color', 'button_style', 'font_family', 'dark_mode_enabled',
        'login_background_image', 'welcome_text', 'custom_css', 'custom_js'
    ];

    protected $casts = [
        'dark_mode_enabled' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
