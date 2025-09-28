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
    Schema::table('users', function (Blueprint $table) {
      //
      $table->string('current_account_stage')->default('verification process')->after('account_status');
      $table->timestamp('interview_at')->nullable()->after('current_account_stage');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      //
      $table->dropColumn('current_account_stage');
      $table->dropColumn('interview_at');
    });
  }
};
