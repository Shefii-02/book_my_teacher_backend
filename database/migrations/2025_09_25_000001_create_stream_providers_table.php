<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamProvidersTable extends Migration
{
  public function up()
  {
    Schema::create('stream_providers', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('slug')->unique(); // short code
      $table->enum('type', ['live_streaming', 'video_hosting', 'custom_rtmp']);
      $table->integer('free_minutes_per_month')->default(0);
      $table->integer('max_participants')->nullable();
      $table->boolean('supports_recording')->default(false);
      $table->boolean('supports_chat')->default(false);
      $table->boolean('supports_screen_share')->default(false);
      $table->boolean('supports_audio_only')->default(false);
      $table->boolean('is_camera_enabled')->default(false);
      $table->boolean('supports_white_board')->default(false);
      $table->enum('billing_model', ['free', 'pay_as_you_go', 'subscription'])->default('free');
      $table->boolean('is_active')->default(true);
      $table->text('description')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('stream_providers');
  }
}
