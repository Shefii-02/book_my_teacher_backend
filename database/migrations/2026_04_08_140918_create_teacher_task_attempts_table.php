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
    Schema::create('teacher_task_attempts', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('task_id');
      $table->unsignedBigInteger('teacher_id');

      $table->timestamp('task_completed_at')->nullable();

      $table->timestamp('verified_at')->nullable();
      $table->unsignedBigInteger('verified_by')->nullable();

      $table->text('notes')->nullable();

      $table->timestamps();

      $table->unique(['task_id', 'teacher_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_task_attempts');
  }
};
