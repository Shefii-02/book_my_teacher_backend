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
    Schema::table('course_registrations', function (Blueprint $table) {
      $table->string('status')->default('pending');
      $table->unsignedBigInteger('payment_id')->nullable()->after('status')->index();
      $table->foreign('payment_id')->references('id')->on('purchases')->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
