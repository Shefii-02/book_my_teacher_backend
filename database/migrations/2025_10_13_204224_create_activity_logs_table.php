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
    Schema::create('activity_logs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->string('action')->nullable(); // e.g. "Search", "Visited Page", "Viewed Course"
      $table->string('reference_name')->nullable(); // e.g. "Course: Flutter for Beginners"
      $table->string('reference_url')->nullable();
      $table->string('device')->nullable();
      $table->string('platform')->nullable();
      $table->string('app_version')->nullable();
      $table->string('ip_address')->nullable();
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_activity_logs');
  }
};
