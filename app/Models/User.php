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


  public function teachingSubjects()
  {
    return $this->belongsToMany(
      Subject::class,                       // Related model
      'teachers_teaching_grade_details',  // Pivot table
      'id',                          // Pivot column referencing Teacher
      'subject_id',                         // Pivot column referencing Grade
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
    // && file_exists(asset('storage/' . $this->avatar->file_path))
    return $this->avatar  ? asset('storage/' . $this->avatar->file_path) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
  }

  public function cv()
  {
    return $this->hasOne(MediaFile::class, 'user_id')->where('file_type', 'cv');
  }

  public function getCvUrlAttribute()
  {
    // && file_exists(asset('storage/' . $this->cv->file_path))
    return $this->cv  ? asset('storage/' . $this->cv->file_path) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
  }


  public function getPerformanceScoreAttribute()
  {
    return 0; // Placeholder for actual performance score calculation
  }

  public function getPerformanceAttribute()
  {
    return 'Medium'; // Placeholder for actual performance level calculation

  }

  public function getRankingAttribute()
  {
    return '---'; // Placeholder for actual ranking calculation
  }

  public function getTotalWatchHoursAttribute()
  {
    return $this->total_watch_hours ?? 0;
  }

  public function getTotalTeachingHoursAttribute()
  {
    return $this->total_teaching_hours ?? 0;
  }

  public function getWalletBalanceAttribute()
  {
    return $this->wallet_balance ?? 0;
  }


  public function getCoursesLaunchedCountAttribute()
  {
    return $this->courses_count ?? 0;
  }

  public function additionalInfo()
  {
    return $this->hasMany(UserAdditionalInfo::class);
  }


  public function teachers()
  {
    return $this->hasMany(Teacher::class, 'user_id', 'id');
  }


  public function teacher()
  {
    return $this->hasOne(Teacher::class, 'user_id', 'id');
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
    return $this->hasMany(WalletHistory::class);
  }

  public function getWalletGreenCoinTotalEarningAttribute()
  {
    return $this->hasMany(WalletHistory::class)->where('type','credit')->where('wallet_type', 'green')->sum('amount') ?? 0;
  }

  public function getWalletRupeesTotalEarningAttribute()
  {
    return $this->hasMany(WalletHistory::class)->where('type','credit')->where('wallet_type', 'rupee')->sum('amount') ?? 0;
  }

  public function getWalletRupeesWithdrawnAttribute()
  {
    return $this->hasMany(WalletHistory::class)->where('type','debit')->where('wallet_type', 'rupee')->sum('amount') ?? 0;
  }


  public function registrations()
  {
    return $this->hasMany(CourseRegistration::class, 'user_id', 'id');
  }


  public function top_teachers()
  {
    return $this->hasMany(TopTeacher::class, 'teacher_id', 'id');
  }

  public function userPlatforms()
  {
    return $this->hasMany(UserPlatform::class, 'user_id', 'id');
  }

  public function courseEnrolled()
  {
    return $this->hasMany(CourseEnrollment::class, 'user_id', 'id');
  }

  public function webinarEnrolled()
  {
    return $this->hasMany(WebinarRegistration::class, 'user_id', 'id');
  }

  public function workshopEnrolled()
  {
    return $this->hasMany(WorkshopRegistration::class, 'user_id', 'id');
  }

  public function attendance()
  {
    return $this->hasMany(Attendance::class, 'student_id', 'id');
  }

  public function payments()
  {
    return $this->hasMany(Purchase::class, 'student_id', 'id');
  }

  public function myScore()
  {
    return $this->hasMany(Purchase::class, 'student_id', 'id');
  }

  public function assignments()
  {
    return $this->hasMany(Purchase::class, 'student_id', 'id');
  }

  public function tests()
  {
    return $this->hasMany(Purchase::class, 'student_id', 'id');
  }

  public function referrals()
  {
    return $this->hasMany(AppReferral::class, 'ref_user_id', 'id');
  }

  public function referredBy()
  {
    return $this->belongsTo(AppReferral::class, 'id', 'referred_user_id');
  }

  public function reviews()
  {
    return $this->hasMany(AppReview::class, 'user_id', 'id');
  }


  public function purchases()
  {
    return $this->hasMany(Purchase::class, 'student_id', 'id');
  }
}
