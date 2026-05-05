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
    Schema::table('class_durations', function (Blueprint $table) {
      if (!Schema::hasColumn('class_durations', 'teacher_id')) {
        $table->string('teacher_id')->nullable(true)->after('course_id');
        $table->index('teacher_id');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('class_durations', function (Blueprint $table) {
      $table->dropColumn('teacher_id');
    });
  }
};
