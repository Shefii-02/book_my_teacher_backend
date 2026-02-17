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
    Schema::table('custom_invoices', function (Blueprint $table) {
     // $table->unsignedBigInteger('student_id');
      // $table->foreignId('company_id')->constrained()->onDelete('cascade')->nullable();
     // $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
