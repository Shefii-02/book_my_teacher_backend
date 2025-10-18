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
    Schema::create('otps', function (Blueprint $table) {
      $table->id();
      $table->string('mobile', 100);
      $table->string('otp', 10);
      $table->boolean('verified')->default(false);
      $table->timestamp('expires_at');
      $table->integer('company_id')->nullable();
      $table->integer('attempt')->nullable();
      $table->string('type')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('otps');
  }
};
