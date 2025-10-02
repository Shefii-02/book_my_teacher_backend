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
      $table->unsignedBigInteger('thumbnail_id')->nullable();
      $table->unsignedBigInteger('mainimage_id')->nullable();
      $table->string('title');
      $table->longText('description')->nullable();
      $table->string('duration_type')->default('days'); // days, weeks, months
      $table->integer('duration')->nullable(); // e.g. 30
      $table->integer('total_hours')->nullable();
      $table->date('started_at')->nullable();
      $table->date('ended_at')->nullable();
      $table->decimal('actual_price', 10, 2)->default(0);
      $table->decimal('discount_price', 10, 2)->nullable();
      $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
      $table->decimal('discount_amount', 10, 2)->nullable();
      $table->boolean('coupon_available')->default(false);
      $table->decimal('net_price', 10, 2)->nullable();
      $table->decimal('gross_price', 10, 2)->nullable();
      $table->enum('is_tax', ['included', 'excluded'])->default('excluded');
      $table->enum('video_type', ['youtube', 'vimeo', 'mp4'])->nullable();
      $table->boolean('has_material')->default(false);
      $table->boolean('has_material_download')->default(false);
      $table->enum('streaming_type', ['live', 'recorded'])->nullable();
      $table->boolean('has_exam')->default(false);
      $table->boolean('is_counselling')->default(false);
      $table->boolean('is_career_guidance')->default(false);
      $table->unsignedBigInteger('company_id')->nullable();
      $table->unsignedBigInteger('created_by')->nullable();

      $table->enum('type', ['offline', 'online', 'recorded'])->default('online');
      $table->timestamps();

      $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('set null');
    });


    Schema::create('course_materials', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('course_id');
        $table->string('title');
        $table->string('file_path')->nullable();
        $table->timestamps();

        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
    });

    Schema::create('course_accessibilities', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('course_id');
        $table->string('role'); // e.g. 'student', 'teacher', 'guest'
        $table->timestamps();

        $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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

  public function down()
  {
    Schema::dropIfExists('livestream_class_teacher');
    Schema::dropIfExists('livestream_classes');
    Schema::dropIfExists('course_classes');
    Schema::dropIfExists('courses');
    Schema::dropIfExists('course_materials');
    Schema::dropIfExists('course_accessibilities');
    Schema::dropIfExists('course_sub_categories');
    Schema::dropIfExists('course_categories');
    Schema::dropIfExists('course_class_permissions');
  }
};
