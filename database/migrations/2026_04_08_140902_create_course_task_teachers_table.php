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
    Schema::create('course_task_teachers', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('course_id');

      $table->string('title');
      $table->text('description')->nullable();

      $table->timestamp('starting_at')->nullable();
      $table->timestamp('due_at')->nullable();

      $table->unsignedBigInteger('created_by');

      $table->enum('status', ['draft', 'published'])->default('draft');
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->timestamps();
      $table->index(['course_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_task_teachers');
  }
};
