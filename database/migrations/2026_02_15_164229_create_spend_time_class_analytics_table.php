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
    Schema::create('spend_class_time_analytics', function (Blueprint $table) {
      $table->id();
      $table->string('type')->nullable();
      $table->integer('class_id')->nullable();
      $table->string('spend_duration')->nullable();
      $table->string('watch_duration')->nullable();
      $table->integer('verified_by')->nullable();
      $table->integer('updated_by')->nullable();
      $table->foreignId('company_id')->constrained()->onDelete('cascade');
      $table->string('status')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('spend_class_time_analytics');
  }
};
