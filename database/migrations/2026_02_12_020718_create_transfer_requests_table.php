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
    Schema::create('transfer_requests', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id')->nullable();
      $table->foreign('company_id')->references('id')->on('users')->onDelete('set null');
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('request_id')->nullable();
      $table->timestamp('requested_at')->nullable();
      $table->decimal('request_amount', 8, 2)->nullable();
      $table->string('approved_by')->nullable();
      $table->timestamp('approved_at')->nullable();
      $table->decimal('approved_amount', 8, 2)->nullable();
      $table->string('transfer_account')->nullable();
      $table->string('status')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transfer_requests');
  }
};
