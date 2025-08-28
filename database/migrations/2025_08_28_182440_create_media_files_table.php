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
    Schema::create('media_files', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->string('file_type'); // avatar, cv, etc.
      $table->string('file_path');
      $table->string('name');
      $table->string('company_id');
      $table->string('mime_type')->nullable();
      $table->timestamps();

      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('media_files');
  }
};
