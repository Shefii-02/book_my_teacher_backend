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
    Schema::create('login_activities', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
      $table->string('provider'); // google, otp, password
      $table->string('source')->nullable(); // web, android, ios
      $table->string('email')->nullable();
      $table->string('ip_address')->nullable();
      $table->string('user_agent')->nullable();
      $table->timestamp('logged_in_at');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('login_activities');
  }
};
