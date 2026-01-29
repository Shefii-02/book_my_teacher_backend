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
    Schema::table('custom_invoices', function (Blueprint $table) {
      $table->string('status')
        ->default('unpaid')
        ->after('grand_total')->comment('draft,unpaid,paid,partial,cancelled')->change();

      $table->date('invoice_expiry_date')->nullable()->after('invoice_date');

      $table->date('payment_date')->nullable()->after('invoice_expiry_date');

      $table->string('payment_method')->nullable()->comment('cash, upi, card, bank, razorpay');

      $table->text('payment_note')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('custom_invoices', function (Blueprint $table) {
      //
    });
  }
};
