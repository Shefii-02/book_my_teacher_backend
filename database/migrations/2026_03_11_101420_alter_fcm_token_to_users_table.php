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
      $table->renameColumn('fcm_token', 'fcm_token_android')->nullable();
      $table->string('fcm_token_ios', 250)->nullable();
      $table->string('fcm_token_web', 250)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('fcm_token');
      $table->dropColumn('fcm_token_ios');
      $table->dropColumn('fcm_token_web');
      //
    });
  }
};
