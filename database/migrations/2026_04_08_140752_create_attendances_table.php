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
    Schema::create('attendances', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('course_id');
      $table->unsignedBigInteger('class_id');
      $table->unsignedBigInteger('student_id');

      $table->unsignedBigInteger('marked_by')->nullable();
      $table->timestamp('attendance_date')->nullable();

      $table->enum('status', ['present', 'absent', 'late', 'none'])->default('none');
      $table->timestamps();
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->unique(['class_id', 'student_id']); // prevent duplicate
      $table->index(['course_id']);
      $table->index(['class_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attendances');
  }
};
