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
    Schema::connection('mysql2')->create('conversation_labels', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedBigInteger('company_id');
      $table->string('color')->nullable();
      $table->integer('position')->default(0);
      $table->timestamps();

      $table->index(['company_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('conversation_labels');
  }
};
