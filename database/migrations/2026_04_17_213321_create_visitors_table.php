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
    Schema::create('visitors', function (Blueprint $table) {
      $table->id();
      $table->integer('company_id')->default(0)->nullable(true);
      $table->integer('user_id')->default(0)->nullable(true);
      $table->string('ip_address')->nullable();
      $table->string('device_info')->nullable();
      $table->string('app_version')->nullable();
      $table->string('platform')->default('android')->nullable(true);
      $table->string('user_agent')->nullable();
      $table->timestamps();

      $table->index('company_id');
      $table->index('user_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('visitors');
  }
};
