<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('course_enrollments', function (Blueprint $table) {

      $table->id();

      $table->unsignedBigInteger('company_id')->index();
      $table->unsignedBigInteger('user_id')->index();
      $table->unsignedBigInteger('course_id')->index();

      $table->decimal('price', 10, 2)->default(0);
      $table->decimal('discount', 10, 2)->default(0);
      $table->decimal('final_price', 10, 2)->default(0);

      $table->date('start_date')->nullable();
      $table->date('expiry_date')->nullable();

      $table->enum('status', [
        'active',
        'expired',
        'suspended',
        'completed'
      ])->default('active');

      $table->enum('payment_status', [
        'paid',
        'unpaid',
        'partial',
        'refunded'
      ])->default('paid');

      $table->timestamp('suspended_at')->nullable();
      $table->text('suspend_reason')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('course_enrollments');
  }
};
