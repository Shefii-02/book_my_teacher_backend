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
    Schema::table('teachers', function (Blueprint $table) {
      if (!Schema::hasColumn('teachers', 'status')) {
        $table->string('rating')->nullable(true)->after('published');
        $table->string('ranking')->nullable(true)->after('published');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('teachers', function (Blueprint $table) {
      $table->dropColumn('rating');
      $table->dropColumn('ranking');
    });
  }
};
