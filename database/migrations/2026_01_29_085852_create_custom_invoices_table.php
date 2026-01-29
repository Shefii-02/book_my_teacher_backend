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
    Schema::create('custom_invoices', function (Blueprint $table) {
      $table->id();
      $table->string('invoice_no')->unique();
      $table->unsignedBigInteger('user_id')->nullable(); // billed to
      $table->string('customer_name');
      $table->string('customer_email')->nullable();
      $table->string('customer_mobile')->nullable();
      $table->text('customer_address')->nullable();

      $table->decimal('subtotal', 10, 2);
      $table->decimal('discount', 10, 2)->default(0);
      $table->decimal('tax_percent', 5, 2)->default(0);
      $table->decimal('tax_amount', 10, 2)->default(0);
      $table->decimal('grand_total', 10, 2);

      $table->enum('status', ['paid', 'unpaid', 'cancelled'])->default('paid');

      $table->date('invoice_date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('custom_invoices');
  }
};
