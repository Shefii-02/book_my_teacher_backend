<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('coupons', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id')->index();
      $table->string('offer_name');
      $table->string('offer_code')->unique();
      $table->enum('coupon_type', ['public', 'private'])->default('public');
      $table->enum('discount_type', ['flat', 'percentage'])->default('flat');
      $table->decimal('discount_value', 10, 2)->nullable();
      $table->decimal('discount_percentage', 5, 2)->nullable();
      $table->decimal('max_discount', 10, 2)->nullable();
      $table->dateTime('start_date_time');
      $table->dateTime('end_date_time')->nullable();
      $table->boolean('is_unlimited')->default(false);
      $table->decimal('minimum_order_value', 10, 2)->nullable();
      $table->enum('course_selection_type', ['all', 'specific'])->default('all');
      $table->boolean('show_inside_courses')->default(false);
      $table->integer('max_usage_per_student')->nullable();
      $table->boolean('is_unlimited_usage')->default(false);
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
      $table->timestamps();
      $table->softDeletes();

    });

    Schema::create('coupon_course', function (Blueprint $table) {
      $table->id();
      $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
      $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('coupon_course');
    Schema::dropIfExists('coupons');
  }
};
