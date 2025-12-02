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
    // General Requests Table
    Schema::create('general_requests', function (Blueprint $table) {
      $table->id();
      $table->string('from_location')->nullable();
      $table->string('grade')->nullable();
      $table->string('board')->nullable();
      $table->string('subject')->nullable();
      $table->text('note')->nullable();
      $table->string('status')->default('pending');
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
    });

    // Banner Requests Table
    Schema::create('banner_requests', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('banner_id');
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
    });

    // Teacher Class Requests Table
    Schema::create('teacher_class_requests', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->enum('type', ['subject', 'course']);
      $table->text('selected_items');
      $table->string('class_type')->nullable();
      $table->integer('days_needed')->nullable();
      $table->text('notes')->nullable();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->unsignedBigInteger('company_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('general_requests');
    Schema::dropIfExists('banner_requests');
    Schema::dropIfExists('teacher_class_requests');
  }
};
