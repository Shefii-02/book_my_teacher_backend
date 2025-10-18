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
    Schema::create('grades', function (Blueprint $table) {
      $table->id();
      $table->string('name');   // e.g. "Lower Primary"
      $table->string('value');  // e.g. "Lower Primary" (for form binding)
      $table->timestamps();
    });

    Schema::create('subjects', function (Blueprint $table) {
      $table->id();
      $table->string('name');   // e.g. "Mathematics"
      $table->string('value');  // e.g. "Mathematics"
      $table->unsignedBigInteger('grade_id')->nullable();
      // optional relation: subject belongs to grade (useful if you want to restrict)

      $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_subjects_and_grades');
  }
};
