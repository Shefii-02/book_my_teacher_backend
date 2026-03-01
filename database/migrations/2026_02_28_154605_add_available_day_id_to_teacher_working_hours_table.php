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
    Schema::table('teacher_working_hours', function (Blueprint $table) {
      $table->unsignedBigInteger('available_day_id')->nullable()->after('teacher_id');
      $table->foreign('available_day_id')
        ->references('id')->on('teacher_working_days')
        ->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::table('teacher_working_hours', function (Blueprint $table) {
      $table->dropColumn('available_day_id');
    });
  }
};
