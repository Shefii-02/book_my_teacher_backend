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

    Schema::table('teachers', function (Blueprint $table) {
      //
      $table->unsignedBigInteger('user_id')->nullable()->after('id')->index();
      $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
