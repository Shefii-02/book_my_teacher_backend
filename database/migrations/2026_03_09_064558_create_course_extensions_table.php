<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {

    Schema::create('course_extensions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('course_id')->index();
      $table->date('old_expiry_date')->nullable();
      $table->date('new_expiry_date')->nullable();
      $table->boolean('payment_required')->default(false);
      $table->decimal('payment_amount', 10, 2)->default(0);
      $table->text('notes')->nullable();
      $table->unsignedBigInteger('created_by')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::create('course_enrollments_extends', function (Blueprint $table) {

      $table->id();

      $table->unsignedBigInteger('course_enrollment_id')->index();

      $table->enum('type', [
        'renewal',
        'extension'
      ])->default('extension');

      $table->date('old_expiry_date')->nullable();
      $table->date('new_expiry_date')->nullable();

      $table->boolean('payment_required')->default(false);
      $table->decimal('payment_amount', 10, 2)->default(0);

      $table->enum('payment_status', [
        'paid',
        'unpaid'
      ])->default('paid');

      $table->string('payment_method')->nullable();

      $table->text('notes')->nullable();

      $table->unsignedBigInteger('created_by')->nullable();

      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('course_extensions');
    Schema::dropIfExists('course_enrollments_extends');
  }
};
