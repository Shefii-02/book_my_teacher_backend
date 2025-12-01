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
    Schema::table('course_classes', function (Blueprint $table) {
      //
      // schedule details
      // $table->date('class_date');
      $table->time('start_time');
      $table->time('end_time')->nullable();
      $table->enum('class_mode', ['gmeet', 'zoom', 'zego', 'agora', 'aws_live'])->default('gmeet');
      $table->string('meeting_link')->nullable();     // live link
      $table->string('meeting_id')->nullable();       // zoom etc.
      $table->string('meeting_password')->nullable();

      // extra details
      $table->boolean('is_recording_available')->default(false);
      $table->string('recording_url')->nullable();

      $table->integer('priority')->default(1);        // class sequence
      $table->boolean('status')->default(true);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('course_classes', function (Blueprint $table) {
      //
    });
  }
};
