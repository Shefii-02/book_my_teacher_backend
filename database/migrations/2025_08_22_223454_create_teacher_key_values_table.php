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
    Schema::create('teacher_key_values', function (Blueprint $table) {
      $table->id();
      $table->string('key')->nullable();
      $table->mediumText('value')->nullable();
      $table->string('user_id')->nullable();
      $table->string('company_id')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_key_values');
  }
};
