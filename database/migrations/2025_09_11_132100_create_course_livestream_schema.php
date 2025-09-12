<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    // 1. Course Categories
    Schema::create('course_categories', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->mediumText('description')->nullable();
      $table->string('thumbnail')->nullable();
      $table->unsignedBigInteger('company_id')->nullable();
      $table->unsignedBigInteger('created_by')->nullable();
      $table->timestamps();

      $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('set null');
    });

    // 2. Course Sub Categories
    Schema::create('course_sub_categories', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('category_id');
      $table->string('title');
      $table->mediumText('description')->nullable();
      $table->string('thumbnail')->nullable();
      $table->unsignedBigInteger('company_id')->nullable();
      $table->unsignedBigInteger('created_by')->nullable();
      $table->timestamps();

      $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('cascade');
      $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('set null');
    });

    // 3. Courses
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->mediumText('description')->nullable();
      $table->string('thumbnail')->nullable();
      $table->unsignedBigInteger('category_id');
      $table->unsignedBigInteger('sub_category_id')->nullable();
      $table->string('duration_type')->default('days'); // days, weeks, months
      $table->integer('duration')->nullable(); // e.g. 30
      $table->timestamp('started_at')->nullable();
      $table->timestamp('ended_at')->nullable();
      $table->unsignedBigInteger('company_id')->nullable();
      $table->unsignedBigInteger('created_by')->nullable();
      $table->enum('type', ['offline', 'online', 'recorded'])->default('online');
      $table->timestamps();

      $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('cascade');
      $table->foreign('sub_category_id')->references('id')->on('course_sub_categories')->onDelete('set null');
      $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('set null');
    });

    // 4. Course Classes
    Schema::create('course_classes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('course_id');
      $table->string('title');
      $table->mediumText('description')->nullable();
      $table->enum('type', ['offline', 'online', 'recorded'])->default('online');
      $table->timestamp('scheduled_at')->nullable();
      $table->unsignedBigInteger('teacher_id')->nullable(); // main teacher
      $table->timestamps();

      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
    });

    // 5. Livestream Classes
    Schema::create('livestream_classes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('class_id');
      $table->string('status')->default('scheduled'); // scheduled, live, ended
      $table->string('room_id')->nullable(); // Zego Room ID
      $table->timestamps();

      $table->foreign('class_id')->references('id')->on('course_classes')->onDelete('cascade');
    });

    // 6. Livestream Teachers (many-to-many)
    Schema::create('livestream_class_teacher', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('livestream_id');
      $table->unsignedBigInteger('teacher_id');
      $table->boolean('is_host')->default(false);
      $table->timestamps();

      $table->foreign('livestream_id')->references('id')->on('livestream_classes')->onDelete('cascade');
      $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('livestream_class_teacher');
    Schema::dropIfExists('livestream_classes');
    Schema::dropIfExists('course_classes');
    Schema::dropIfExists('courses');
    Schema::dropIfExists('course_sub_categories');
    Schema::dropIfExists('course_categories');
  }
};
