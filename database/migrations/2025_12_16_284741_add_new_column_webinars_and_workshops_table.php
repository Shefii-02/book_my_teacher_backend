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

    Schema::table('webinar_registrations', function (Blueprint $table) {
      $table->unsignedBigInteger('company_id')->nullable()->after('id')->index();
      $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
    });

    Schema::table('workshop_registrations', function (Blueprint $table) {
      $table->unsignedBigInteger('company_id')->nullable()->after('id')->index();
      $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
