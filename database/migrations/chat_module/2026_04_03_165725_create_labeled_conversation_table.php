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
    Schema::connection('mysql2')->create('labeled_conversation', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('conversation_id');
      $table->unsignedBigInteger('label_id');

      $table->unique(['conversation_id', 'label_id']);
      $table->index(['conversation_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('labeled_conversation');
  }
};
