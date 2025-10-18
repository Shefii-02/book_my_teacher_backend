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
    Schema::create('student_personal_info', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('student_id');
      $table->string('parent_email')->nullable();
      $table->string('parent_mobile')->nullable();
      $table->string('parent_name')->nullable();
      $table->string('parent_relation')->nullable();
      $table->string('current_eduction')->nullable();
      $table->string('study_mode')->nullable();
      $table->timestamps();
      $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_personal_info');
  }
};
