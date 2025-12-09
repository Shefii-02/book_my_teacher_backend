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
    Schema::table('course_categories', function (Blueprint $table) {
      //

      $table->integer('position')->default(0)->after('created_by');
      $table->boolean('status')->default(true)->after('position');
    });

    Schema::table('course_sub_categories', function (Blueprint $table) {
      //

      $table->integer('position')->default(0);
      $table->boolean('status')->default(true)->after('position');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
