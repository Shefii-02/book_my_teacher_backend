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
    Schema::table('purchase_installments', function (Blueprint $table) {

      $table->dateTime('pay_from')->nullable(true)->after('purchase_id');
      $table->string('course_id')->nullable(true)->after('purchase_id');
      $table->integer('student_id')->nullable(true)->after('purchase_id');
      $table->integer('company_id')->nullable(true)->after('id');

      $table->index('student_id');
      $table->index('course_id');
      $table->index('company_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('purchase_installments', function (Blueprint $table) {
      $table->dropColumn('course_id');
      $table->dropColumn('student_id');
      $table->dropColumn('pay_from');
      $table->dropColumn('company_id');
    });
  }
};
