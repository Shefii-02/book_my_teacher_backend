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
    Schema::create('course_category', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('course_id')->nullable();
      $table->unsignedBigInteger('course_category_id')->nullable();
      $table->json('subcategories')->nullable();
      $table->timestamps();


      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->foreign('course_category_id')->references('id')->on('course_categories')->onDelete('cascade');
    });
  }



  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_category');
  }
};
