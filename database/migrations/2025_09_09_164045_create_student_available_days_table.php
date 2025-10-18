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
    Schema::create('student_available_days', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('student_id');
      $table->string('day'); // e.g., Sun, Mon, etc.
      $table->timestamps();
      $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('student_available_days');
  }
};
