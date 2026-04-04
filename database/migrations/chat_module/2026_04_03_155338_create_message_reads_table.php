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
    Schema::connection($this->connection)->create('message_reads', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('message_id');
      $table->unsignedBigInteger('user_id');
      $table->dateTime('read_at')->nullable();

      $table->unique(['message_id', 'user_id']);
      $table->index('message_id');
      $table->index('user_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('message_reads');
  }
};
