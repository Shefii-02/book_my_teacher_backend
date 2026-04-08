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
    Schema::create('class_durations', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('class_id');
      $table->unsignedBigInteger('course_id');

      $table->timestamp('started_at')->nullable();
      $table->timestamp('ended_at')->nullable();

      $table->decimal('duration', 8, 2)->comment('in_minutes')->nullable(); // planned duration (minutes)
      $table->decimal('actual_duration', 8, 2)->comment('in_minutes')->nullable(); // real duration
      $table->decimal('extra_minutes', 8, 2)->comment('in_minutes')->nullable(); // real duration

      $table->text('note')->nullable();

      $table->unsignedBigInteger('verified_by')->nullable();
      $table->timestamp('verified_at')->nullable();
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->enum('status', ['pending', 'completed', 'verified'])->default('pending');

      $table->timestamps();
      $table->index(['course_id']);
      $table->index(['class_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('class_durations');
  }
};
