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
    // subject_courses
    Schema::create('subject_courses', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreignId('subject_id')->constrained()->onDelete('cascade');
      $table->string('title');
      $table->text('description')->nullable();
      $table->string('main_image')->nullable();
      $table->timestamps();
    });

    // subject_reviews
    Schema::create('subject_reviews', function (Blueprint $table) {
      $table->id();
      $table->foreignId('subject_id')->constrained()->onDelete('cascade');
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('subject_course_id')->nullable()->constrained()->onDelete('set null');
      $table->text('comments');
      $table->decimal('rating', 8, 2)->default(5.0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('subject_reviews');
    Schema::dropIfExists('subject_courses');
  }
};
