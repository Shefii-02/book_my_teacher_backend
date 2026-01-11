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
    Schema::create('demo_classes', function (Blueprint $table) {
      $table->id();

      // Basic info
      $table->string('title');
      $table->longText('description')->nullable();
      $table->string('slug')->unique();

      // Images / Media
      $table->string('thumbnail_image')->nullable(); // small card display

      // Host (link to users table)
      $table->foreignId('host_id')->constrained('users')->onDelete('cascade');

      // Stream provider info
      $table->foreignId('stream_provider_id')->constrained('stream_providers')->onDelete('cascade');
      $table->string('live_id')->unique(); // provider-specific room/live ID
      $table->string('recording_url')->nullable(); // optional recorded file link
      $table->string('meeting_url')->nullable();   // join link for external providers (Zoom, etc.)

      // Webinar scheduling
      $table->dateTime('started_at')->nullable();
      $table->dateTime('ended_at')->nullable();

      // Access & roles
      $table->integer('max_participants')->nullable();

      // Features
      $table->boolean('is_record_enabled')->default(false);
      $table->boolean('is_chat_enabled')->default(true);
      $table->boolean('is_screen_share_enabled')->default(true);
      $table->boolean('is_whiteboard_enabled')->default(false);
      $table->boolean('is_camera_enabled')->default(false);
      $table->boolean('is_audio_only_enabled')->default(false);
      $table->integer('institute_id')->nullable();
      $table->decimal('actual_price', 10, 2)->default(0);
      $table->decimal('discount_price', 10, 2)->nullable();
      $table->decimal('net_price', 10, 2)->default(0);
      // Status
      $table->enum('status', ['draft', 'scheduled', 'live', 'ended'])->default('draft');
      $table->boolean('is_public')->default(true);

      // Misc
      $table->json('tags')->nullable(); // searchable tags like ["math","english"]
      $table->json('meta')->nullable();
      $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('demo_classes');
  }
};
