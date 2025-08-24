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
    Schema::create('teacher_personals', function (Blueprint $table) {
      $table->id();
      $table->string('user_id')->nullable();
      $table->string('avatar')->nullable();
      $table->string('full_name')->nullable();
      $table->string('email')->nullable();
      $table->string('address')->nullable();
      $table->string('city')->nullable();
      $table->string('postal_code')->nullable();
      $table->string('district')->nullable();
      $table->string('state')->nullable();
      $table->string('country')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_personals');
  }
};
