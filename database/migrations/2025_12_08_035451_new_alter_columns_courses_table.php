<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    //


    // 1) Rename columns safely (ENUM column rename must be isolated)
    Schema::table('courses', function (Blueprint $table) {
      $table->renameColumn('video_type', 'class_type');
      $table->renameColumn('streaming_type', 'course_type');
    });



    // 3) Add new columns
    Schema::table('courses', function (Blueprint $table) {
      $table->string('level')->nullable()->after('course_type');
      $table->integer('position')->default(0)->after('course_type');
      $table->decimal('course_percentage')->default(0.0)->after('course_type');
      $table->integer('institute_id')->nullable()->after('course_type');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
