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

    Schema::table('courses', function (Blueprint $table) {
      //
      $table->boolean('allow_installment')->default(0)->nullable('coupon_available');
    });


  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
