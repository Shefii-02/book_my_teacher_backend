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
    Schema::connection('mysql2')->table('conversations', function (Blueprint $table) {
      //
      $table->timestamp('updated_at')->nullable();
    });
    Schema::connection('mysql2')->table('messages', function (Blueprint $table) {
      //
      $table->timestamp('updated_at')->nullable();
    });
    Schema::connection('mysql2')->table('users', function (Blueprint $table) {
      //
      $table->timestamp('updated_at')->nullable();
    });
    Schema::connection('mysql2')->table('conversation_members', function (Blueprint $table) {

      $table->timestamp('created_at')->nullable();   $table->timestamp('updated_at')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::connection('mysql2')->table('conversations', function (Blueprint $table) {
      $table->dropColumn('updated_at');
      //
    });
    Schema::connection('mysql2')->table('messages', function (Blueprint $table) {
      $table->dropColumn('updated_at');
      //
    });
    Schema::connection('mysql2')->table('users', function (Blueprint $table) {
      $table->dropColumn('updated_at');
      //
    });
    Schema::connection('mysql2')->table('conversation_members', function (Blueprint $table) {
      $table->dropColumn('updated_at');
      $table->dropColumn('created_at');
      //
    });
  }
};
