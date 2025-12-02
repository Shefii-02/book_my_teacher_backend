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
    Schema::create('social_links', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id');
      $table->string('name');
      $table->string('icon')->nullable(); // store image path
      $table->string('link');
      $table->string('type')->nullable();
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('social_links');
  }
};
