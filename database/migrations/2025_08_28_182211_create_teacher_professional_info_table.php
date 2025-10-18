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
    Schema::create('teacher_professional_info', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->string('profession')->nullable();
      $table->enum('ready_to_work', ['Yes', 'No'])->default('Yes');
      $table->string('experience')->nullable(); // can store JSON if multiple
      $table->integer('offline_exp')->default(0);
      $table->integer('online_exp')->default(0);
      $table->integer('home_exp')->default(0);
      $table->timestamps();

      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_professional_info');
  }
};
