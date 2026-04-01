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

    Schema::create('app_reviews', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('rating')->nullable(); // 1 to 5
      $table->mediumText('feedback')->nullable();
      $table->string('status')->default('pending')->nullable();
      $table->boolean('show_dispaly')->default('0')->nullable();
      $table->timestamps();

      $table->unique(['user_id', 'teacher_id']); // one review per user per teacher
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('app_reviews');
  }
};
