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
    Schema::table('banner_requests', function (Blueprint $table) {
      // $table->mediumText('notes')->nullable();
      // $table->string('status')->default('pending');
    });

    Schema::table('teacher_class_requests', function (Blueprint $table) {
      // $table->mediumText('lead_notes')->nullable();
      // $table->string('status')->default('pending');
    });

  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
