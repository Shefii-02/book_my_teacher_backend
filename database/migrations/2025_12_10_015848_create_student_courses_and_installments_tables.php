<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    // purchases (student_courses equivalent)
    Schema::create('purchases', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('student_id')->index();
      $table->unsignedBigInteger('course_id')->index();
      $table->string('coupon_code')->nullable();
      $table->decimal('price', 12, 2)->default(0);              // original price
      $table->decimal('discount_amount', 12, 2)->default(0);
      $table->decimal('tax_amount', 12, 2)->default(0);
      $table->decimal('grand_total', 12, 2)->default(0);
      $table->boolean('tax_included')->default(false); // true => prices already include tax
      $table->decimal('tax_percent', 8, 2)->default(0); // percent      // final payable
      $table->boolean('is_installment')->default(false);
      $table->integer('installments_count')->nullable();
      $table->integer('installment_interval_months')->nullable();
      $table->decimal('installment_additional_amount', 12, 2)->default(0);
      $table->text('notes')->nullable();
      $table->string('status')->comment('pending', 'paid', 'failed', 'cancelled', 'swapped', 'waiting installment')->default('pending');
      $table->unsignedBigInteger('created_by')->nullable();
      $table->string('payment_method')->comment('manually', 'gateway', 'in cash')->nullable();
      $table->string('payment_source')->comment('web', 'app', 'direct')->nullable();
      $table->timestamps();

      $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
      $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
    });

    // installments
    Schema::create('purchase_installments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('purchase_id')->index();
      $table->date('due_date')->nullable();
      $table->decimal('amount', 12, 2)->default(0);
      $table->decimal('paid_amount', 12, 2)->default(0);
      $table->date('paid_date')->nullable();
      $table->integer('paid_by')->nullable();
      $table->boolean('is_paid')->default(false);
      $table->string('payment_method')->comment('manually', 'gateway', 'in cash')->nullable();
      $table->string('payment_source')->comment('web', 'app', 'direct')->nullable();
      $table->timestamps();

      $table->foreign('purchase_id')->references('id')->on('purchases')->cascadeOnDelete();
    });

    // payment transactions (store gateway response)
    Schema::create('purchase_payments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('purchase_id')->index();
      $table->string('gateway')->default('phonepe');
      $table->string('transaction_id')->nullable();
      $table->string('order_id')->nullable();
      $table->decimal('amount', 12, 2)->default(0);
      $table->string('currency')->default('INR');
      $table->json('payload')->nullable(); // store raw gateway response
      $table->enum('status', ['initiated', 'success', 'failed', 'unknown'])->default('initiated');
      $table->timestamps();

      $table->foreign('purchase_id')->references('id')->on('purchases')->cascadeOnDelete();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('purchase_payments');
    Schema::dropIfExists('purchase_installments');
    Schema::dropIfExists('purchases');
  }
};
