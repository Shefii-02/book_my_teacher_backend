<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'slug',
    'thumbnail_image',
    'main_image',
    'host_id',
    'stream_provider_id',
    'live_id',
    'recording_url',
    'meeting_url',
    'started_at',
    'ended_at',
    'registration_end_at',
    'is_teacher_allowed',
    'is_student_allowed',
    'is_guest_allowed',
    'max_participants',
    'is_record_enabled',
    'is_chat_enabled',
    'is_screen_share_enabled',
    'is_whiteboard_enabled',
    'is_camera_enabled',
    'is_audio_only_enabled',
    'status',
    'is_public',
    'tags',
    'meta',
    'company_id',
    'provider_app_id',
  ];

  protected $casts = [
    'started_at' => 'datetime',
    'ended_at' => 'datetime',
    'registration_end_at' => 'datetime',
    'is_teacher_allowed' => 'boolean',
    'is_student_allowed' => 'boolean',
    'is_guest_allowed' => 'boolean',
    'is_record_enabled' => 'boolean',
    'is_chat_enabled' => 'boolean',
    'is_screen_share_enabled' => 'boolean',
    'is_whiteboard_enabled' => 'boolean',
    'is_audio_only_enabled' => 'boolean',
    'is_public' => 'boolean',
    'tags' => 'array',
    'meta' => 'array',
  ];

  /**
   * Webinar belongs to a Host (User)
   */
  public function host()
  {
    return $this->belongsTo(User::class, 'host_id');
  }

  /**
   * Webinar belongs to a Stream Provider
   */
  public function provider()
  {
    return $this->belongsTo(StreamProvider::class, 'stream_provider_id');
  }

  /**
   * Optional: Helper to check if a role is allowed
   */
  public function isRoleAllowed(string $role): bool
  {
    return match ($role) {
      'teacher' => $this->is_teacher_allowed,
      'student' => $this->is_student_allowed,
      'guest' => $this->is_guest_allowed,
      default => false,
    };
  }

  public function providerApp() {
        return $this->belongsTo(ProviderCredential::class, 'provider_app_id');
    }

  public function registrations()
  {
    return $this->hasMany(WebinarRegistration::class);
  }
}
