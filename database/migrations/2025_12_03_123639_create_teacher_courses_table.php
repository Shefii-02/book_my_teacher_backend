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
    Schema::create('teacher_courses', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
      $table->unsignedBigInteger('course_id')->nullable();
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->timestamps();

      $table->unique(['teacher_id', 'course_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_courses');
  }
};
