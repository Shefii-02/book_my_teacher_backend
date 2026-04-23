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
    Schema::table('user_platforms', function (Blueprint $table) {
      if (!Schema::hasColumn('user_platforms', 'status')) {
        $table->string('status')->nullable(true)->after('fcm_token');
      }
      if (!Schema::hasColumn('user_platforms', 'device_id')) {
        $table->string('device_id')->nullable(true)->after('status');
      }

      if (!Schema::hasColumn('user_platforms', 'city')) {
        $table->string('city')->nullable(true)->after('device_id');
      }

      if (!Schema::hasColumn('user_platforms', 'district')) {
        $table->string('district')->nullable(true)->after('device_id');
      }

      if (!Schema::hasColumn('user_platforms', 'latitude')) {
        $table->string('latitude')->nullable(true)->after('device_id');
        $table->string('longitude')->nullable(true)->after('latitude');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('user_platforms', function (Blueprint $table) {
      $table->dropColumn('status');
      $table->dropColumn('device_id');
      $table->dropColumn('city');
      $table->dropColumn('district');
      $table->dropColumn('latitude');
      $table->dropColumn('longitude');
    });
  }
};
