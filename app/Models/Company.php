<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  use HasFactory;


  public static function createCompanyRoles($company_id)
  {
    // Create company role
    $role_c             = new Role();
    $role_c->name       = 'company-' . $company_id;
    $role_c->guard_name = 'web';
    $role_c->created_by = $company_id;
    $role_c->is_editable = 1;
    $role_c->is_deletable = 0;
    $role_c->save();

    // $companyPermissions = Permission::where('is_company', '1')->get();
    // $role_c->givePermissionTo($companyPermissions);

    // Create tenant role
    $role_t       = new Role();
    $role_t->name = 'student-' . $company_id;
    $role_t->guard_name = 'web';
    $role_t->created_by = $company_id;
    $role_t->is_editable = 1;
    $role_t->is_deletable = 0;
    $role_t->save();

    // $tenantPermissions = Permission::where('is_tenant', '1')->get();
    // $role_t->givePermissionTo($tenantPermissions);

    // Create owner role
    $role_o       = new Role();
    $role_o->name = 'teacher-' . $company_id;
    $role_o->guard_name = 'web';
    $role_o->created_by = $company_id;
    $role_o->is_editable = 1;
    $role_o->is_deletable = 0;
    $role_o->save();

    // $ownerPermissions = Permission::where('is_owner', '1')->get();
    // $role_o->givePermissionTo($ownerPermissions);

  }




  protected static function boot()
  {
    parent::boot();

    static::creating(function ($company) {
      $company->api_key = self::generateUniqueApiKey();
    });
  }


  protected $fillable = [
    'name',
    'slug',
    'logo',
    'favicon',
    'email',
    'phone',
    'whatsapp',
    'website',
    'address_line1',
    'address_line2',
    'api_key',
    'city',
    'state',
    'country',
    'pincode',
    'timezone',
    'date_format',
    'currency',
    'plan_id',
    'financial_year_start',
    'financial_year_end',
    'trial_ends_at',
    'is_active',
  ];

  /* -------------------------
     | Relationships
     ------------------------- */



  public function settings()
  {
    return $this->hasMany(CompanySetting::class);
  }

  public function socialLinks()
  {
    return $this->hasMany(SocialLink::class);
  }

  public function branding()
  {
    return $this->hasOne(CompanyBranding::class);
  }

  public function contacts()
  {
    return $this->hasMany(CompanyContact::class);
  }

  public function paymentSettings()
  {
    return $this->hasMany(CompanyPaymentSetting::class);
  }

  public function storageSettings()
  {
    return $this->hasOne(CompanyStorageSetting::class);
  }

  public function security()
  {
    return $this->hasOne(CompanySecuritySetting::class);
  }

  public function integrations()
  {
    return $this->hasMany(CompanyIntegration::class);
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }


  public function user()
  {
    return $this->hasOne(User::class,'id','user_id');
  }


  public function getSetting($key, $default = null)
  {
    return optional($this->settings->where('key', $key)->first())->value ?? $default;
  }





  public function faviconLogoMedia()
  {
    return $this->belongsTo(MediaFile::class, 'favicon');
  }


  public function whiteLogoMedia()
  {
    return $this->belongsTo(MediaFile::class, 'white_logo');
  }

  public function blackLogoMedia()
  {
    return $this->belongsTo(MediaFile::class, 'black_logo');
  }

  public function getFaviconUrlAttribute()
  {
    return $this->faviconLogoMedia ? asset('storage/' . $this->faviconLogoMedia->file_path) : null;
  }

  public function getBlackLogoUrlAttribute()
  {
    return $this->blackLogoMedia  ? asset('storage/' . $this->blackLogoMedia->file_path) : null;
  }

  public function getWhiteLogoUrlAttribute()
  {
    return $this->whiteLogoMedia ? asset('storage/' . $this->whiteLogoMedia->file_path) : null;
  }







  public static function generateUniqueApiKey()
  {
    $characters = 'ABCDEFGHIJK456789LMNOPQRSTUVWXYZ0123';

    do {
      $random = substr(str_shuffle($characters), 0, 156);
      $code = 'BMS-' . $random;
    } while (self::where('api_key', $code)->exists());

    return $code;
  }
}
