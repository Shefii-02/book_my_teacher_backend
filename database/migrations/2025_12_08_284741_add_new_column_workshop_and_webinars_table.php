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
    Schema::table('workshops', function (Blueprint $table) {
      $table->decimal('actual_price', 10, 2)->default(0);
      $table->decimal('discount_price', 10, 2)->nullable();
      $table->decimal('net_price', 10, 2)->default(0);
    });

    Schema::table('webinars', function (Blueprint $table) {
      //
      $table->decimal('actual_price', 10, 2)->default(0);
      $table->decimal('discount_price', 10, 2)->nullable();
      $table->decimal('net_price', 10, 2)->default(0);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
