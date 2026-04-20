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
    Schema::table('purchases', function (Blueprint $table) {
      if (!Schema::hasColumn('purchases', 'company_id')) {
        $table->integer('company_id')->default(0)->nullable(true)->after('status');
      }
      if (!Schema::hasColumn('purchases', 'platform')) {
        $table->string('platform')->default('android')->after('status');
      }
      if (!Schema::hasColumn('purchases', 'currency')) {
        $table->string('currency')->nullable(true)->default('INR')->after('price');
      }
      $table->index('company_id');
    });


    Schema::create('course_payments', function (Blueprint $table) {

      $table->id();
      $table->integer('purchase_id')->default(0)->nullable(true);
      $table->integer('course_enrollment_id')->default(0)->nullable(true);
      $table->integer('course_id')->default(0)->nullable(true);
      $table->integer('company_id')->default(0)->nullable(true);
      $table->integer('student_id')->default(0)->nullable(true);
      $table->timestamps();

      $table->index('purchase_id');
      $table->index('company_id');
      $table->index('course_id');
      $table->index('student_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('purchases', function (Blueprint $table) {
      if (Schema::hasColumn('purchases', 'platform')) {
        $table->dropColumn('platform');
      }
      if (!Schema::hasColumn('purchases', 'company_id')) {
        $table->dropColumn('company_id');
      }
    });

    Schema::dropIfExists('course_payments');
  }
};
