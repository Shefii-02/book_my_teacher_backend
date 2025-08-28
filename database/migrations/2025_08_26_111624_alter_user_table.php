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
    //
    Schema::table('users', function (Blueprint $table) {
      $table->string('mobile')->nullable()->after('name');
      $table->boolean('mobile_verified')->default(false)->after('mobile');
      $table->string('acc_type')->nullable()->after('mobile_verified');
      $table->string('company_id')->nullable()->after('acc_type');
      $table->string('last_login')->nullable()->after('company_id');
      $table->integer('profile_fill')->default(0)->nullable()->after('last_login');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
