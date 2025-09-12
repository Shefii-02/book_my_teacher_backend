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
    Schema::create('course_class_permissions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('class_id');
      $table->enum('mode', ['one_to_one', 'group'])->default('group');
      $table->boolean('allow_voice')->default(true);
      $table->boolean('allow_video')->default(false);
      $table->boolean('allow_chat')->default(true);
      $table->boolean('allow_screen_share')->default(false);
      $table->timestamps();

      $table->foreign('class_id')->references('id')->on('course_classes')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('course_class_permissions');
  }
};
