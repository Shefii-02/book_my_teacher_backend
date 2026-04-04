<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  protected $connection = 'mysql2';

  public function up()
  {
    Schema::connection($this->connection)->create('message_report', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('message_id');
      $table->unsignedBigInteger('conversation_id');
      $table->unsignedBigInteger('reported_by');

      $table->timestamp('reported_at')->useCurrent();

      $table->unsignedBigInteger('verified_by')->nullable();
      $table->dateTime('verified_at')->nullable();

      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

      $table->unique(['message_id', 'reported_by']);

      $table->index('message_id');
      $table->index('conversation_id');
      $table->index('reported_by');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('message_report');
  }
};
