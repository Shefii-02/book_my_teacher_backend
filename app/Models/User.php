<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

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

  public function professionalInfo()
  {
    return $this->hasOne(TeacherProfessionalInfo::class, 'teacher_id');
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



  public function recommendedSubjects()
  {
    return $this->hasMany(StudentRecommendedSubject::class, 'student_id');
  }

  public function studentPersonalInfo(){
    return $this->hasOne(StudentPersonalInfo::class, 'student_id');
  }

  public function studentGrades(){
        return $this->hasMany(StudentGrade::class, 'student_id');
  }




}
