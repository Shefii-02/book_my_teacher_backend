<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles; // <-- ADD THIS


class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'mobile',
    'address',
    'city',
    'postal_code',
    'district',
    'state',
    'country',
    'company_id',
    'acc_type',
    'account_status',
    'status',
    'registration_source',
    'last_login_source',
    'profile_fill',
    ''
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($user) {
      $user->referral_code = self::generateUniqueReferralCode();
    });
  }



  public function professionalInfo()
  {
    return $this->hasOne(TeacherProfessionalInfo::class, 'teacher_id');
  }

  public function teachingDetails()
  {
    return $this->hasMany(TeachersTeachingGradeDetail::class);
  }



  public function teachingGrades()
  {
    return $this->belongsToMany(
      Grade::class,                       // Related model
      'teachers_teaching_grade_details',  // Pivot table
      'id',                               // Pivot column referencing User
      'grade_id',                         // Pivot column referencing Grade
      'id',                          // Local key on User table
      'id'                                // Local key on Grade table
    )->distinct();
  }

  public function teachingBoards()
  {
    return $this->belongsToMany(
      Board::class,                       // Related model
      'teachers_teaching_grade_details',  // Pivot table
      'id',                          // Pivot column referencing Teacher
      'board_id',                         // Pivot column referencing Grade
      'id',                          // Local key on Teacher table
      'id'                                // Local key on Grade table
    )->distinct();
  }


    public function courses()
  {

    return $this->belongsToMany(
        Course::class,
        'teacher_courses',
        'id', // Pivot column referencing Teacher
        'course_id',  // Pivot column referencing Course
        'id',         // Local key on Teacher table
        'id'          // Local key on Course table
    );
  }



  public function teacherGrades()
  {
    return $this->hasMany(TeacherGrade::class, 'teacher_id');
  }

  public function subjects()
  {
    return $this->hasMany(TeachingSubject::class, 'teacher_id');
  }

  public function workingDays()
  {
    return $this->hasMany(TeacherWorkingDay::class, 'teacher_id');
  }

  public function workingHours()
  {
    return $this->hasMany(TeacherWorkingHour::class, 'teacher_id');
  }

  public function mediaFiles()
  {
    return $this->hasMany(MediaFile::class, 'user_id');
  }

  public function avatar()
  {
    return $this->hasOne(MediaFile::class, 'user_id')->where('file_type', 'avatar');
  }

  public function getAvatarUrlAttribute()
  {
    return $this->avatar ? asset('storage/' . $this->avatar->file_path) : asset('default-avatar.png');
  }

  public function cv()
  {
    return $this->hasOne(MediaFile::class, 'user_id')->where('file_type', 'cv');
  }

  public function getCvUrlAttribute()
  {
    return $this->cv ? asset('storage/' . $this->cv->file_path) : asset('default-avatar.png');
  }

  public function additionalInfo()
  {
    return $this->hasMany(UserAdditionalInfo::class);
  }


  public function teachers()
  {
    return $this->hasMany(Teacher::class, 'user_id', 'id');
  }


  public function company()
  {
    return $this->hasOne(Company::class, 'id', 'company_id');
  }


  // public static function generateUniqueReferralCode()
  // {
  //   do {
  //     $code = 'BMT-' . rand(100000, 999999);
  //   } while (self::where('referral_code', $code)->exists());

  //   return $code;
  // }

  public static function generateUniqueReferralCode()
  {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    do {
      $random = substr(str_shuffle($characters), 0, 6);
      $code = 'BMT-' . $random;
    } while (self::where('referral_code', $code)->exists());

    return $code;
  }


  public function recommendedSubjects()
  {
    return $this->hasMany(StudentRecommendedSubject::class, 'student_id');
  }

  public function studentPersonalInfo()
  {
    return $this->hasOne(StudentPersonalInfo::class, 'student_id');
  }

  public function studentGrades()
  {
    return $this->hasMany(StudentGrade::class, 'student_id');
  }

  public function preferredDays()
  {
    return $this->hasMany(StudentAvailableDay::class, 'student_id');
  }

  public function preferredHours()
  {
    return $this->hasMany(StudentAvailableHour::class, 'student_id');
  }

  public function activityLogs()
  {
    return $this->hasMany(ActivityLog::class, 'id', 'user_id');
  }

  public function getRoleNameAttribute()
  {
    $rolename = $this->getRoleNames()->first() ? preg_replace('/[-\d~]/', '',  $this->getRoleNames()->first()) : null;
    return $rolename;
  }


  public function payroll()
  {
    return $this->hasOne(PayrollDetail::class, 'user_id', 'id');
  }

  public function wallet()
  {
    return $this->hasOne(Wallet::class, 'user_id', 'id');
  }

  public function walletHistories()
  {
    return $this->hasMany(\App\Models\WalletHistory::class);
  }

  public function registrations()
  {
    return $this->hasMany(CourseRegistration::class, 'user_id', 'id');
  }


  public function top_teachers()
  {
    return $this->hasMany(TopTeacher::class, 'teacher_id', 'id');
  }
}
