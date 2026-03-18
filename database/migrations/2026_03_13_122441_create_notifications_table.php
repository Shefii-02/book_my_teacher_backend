<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // 1. Notification Templates Table
    Schema::create('notification_templates', function (Blueprint $table) {
      $table->id();
      $table->string('key')->unique(); // course_created, class_started, etc.
      $table->string('title');
      $table->text('body');
      $table->string('type'); // push | in_app | both
      $table->string('category'); // course | webinar | workshop | admission | reward etc.
      $table->json('variables')->nullable(); // ["course_name", "teacher_name"]
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });

    // 2. Main Notifications Table
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('body');
      $table->string('type');             // push | in_app | both
      $table->string('category');         // course | webinar | workshop | admission etc.
      $table->string('action_type');      // created | updated | started | deleted etc.
      $table->string('notifiable_type')->nullable(); // Course | Webinar | Workshop etc.
      $table->unsignedBigInteger('notifiable_id')->nullable();

      // Target audience
      $table->string('target_type');      // all | role | specific
      $table->string('target_role')->nullable(); // admin | teacher | student | staff
      $table->json('target_user_ids')->nullable(); // [1,2,3] specific users

      // FCM data
      $table->string('screen')->nullable();       // course_detail | chat etc.
      $table->string('screen_id')->nullable();    // ID to navigate to
      $table->json('extra_data')->nullable();     // additional data

      // Stats
      $table->unsignedInteger('sent_count')->default(0);
      $table->unsignedInteger('read_count')->default(0);
      $table->unsignedInteger('failed_count')->default(0);

      $table->foreignId('created_by')->constrained('users');
      $table->timestamp('scheduled_at')->nullable();
      $table->timestamp('sent_at')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    // 3. Notification Recipients (per user log)
    Schema::create('notification_recipients', function (Blueprint $table) {
      $table->id();
      $table->foreignId('notification_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->boolean('is_read')->default(false);
      $table->boolean('is_push_sent')->default(false);
      $table->boolean('is_push_failed')->default(false);
      $table->string('push_error')->nullable();
      $table->timestamp('read_at')->nullable();
      $table->timestamp('push_sent_at')->nullable();
      $table->timestamps();

      $table->index(['user_id', 'is_read']);
      $table->index(['notification_id', 'user_id']);
    });

    // 4. User Notification Settings
    Schema::create('user_notification_settings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();

      // Per category toggles
      $table->boolean('admission')->default(true);
      $table->boolean('course')->default(true);
      $table->boolean('webinar')->default(true);
      $table->boolean('workshop')->default(true);
      $table->boolean('demo_class')->default(true);
      $table->boolean('invoice')->default(true);
      $table->boolean('reward')->default(true);
      $table->boolean('achievement')->default(true);
      $table->boolean('transfer')->default(true);
      $table->boolean('spend_time')->default(true);
      $table->boolean('chat')->default(true);

      // Channel toggles
      $table->boolean('push_enabled')->default(true);
      $table->boolean('in_app_enabled')->default(true);
      $table->boolean('email_enabled')->default(false);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('notifications');
    Schema::dropIfExists('notification_templates');
    Schema::dropIfExists('notifications');
    Schema::dropIfExists('notification_recipients');
    Schema::dropIfExists('user_notification_settings');
  }
};
