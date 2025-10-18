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
    Schema::create('teacher_grades', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->string('grade'); // e.g., lowerPrimary, higherPrimary
      $table->timestamps();

      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_grades');
  }
};
