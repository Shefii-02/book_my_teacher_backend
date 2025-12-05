<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('delete_account_requests', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id');
      $table->unsignedBigInteger('user_id');
      $table->string('reason')->nullable();
      $table->text('description')->nullable();
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
      $table->timestamp('approved_at')->nullable();
      $table->timestamp('rejected_at')->nullable();
      $table->timestamps();
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('delete_account_requests');
  }
};
