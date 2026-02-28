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
    Schema::create('teachers_teaching_grade_details', function (Blueprint $table) {
      $table->id();

      $table->foreignId('user_id')
        ->constrained('users')
        ->cascadeOnDelete();

      $table->foreignId('grade_id')
        ->constrained('grades')
        ->cascadeOnDelete();

      $table->foreignId('board_id')
        ->constrained('boards')
        ->cascadeOnDelete();

      $table->foreignId('subject_id')
        ->constrained('subjects')
        ->cascadeOnDelete();

      $table->boolean('online')->default(false);
      $table->boolean('offline')->default(false);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teachers_teaching_grade_details');
  }
};
