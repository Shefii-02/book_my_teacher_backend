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
    Schema::connection($this->connection)->create('messages', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('conversation_id');
      $table->unsignedBigInteger('sender_id');

      $table->text('content')->nullable();
      $table->string('message_type')->default('text');

      $table->text('file_url')->nullable();
      $table->string('file_name')->nullable();
      $table->integer('file_size')->nullable();
      $table->integer('duration_sec')->nullable();

      $table->enum('status', ['sent', 'delivered', 'seen'])->default('sent');
      $table->boolean('is_read')->default(false);

      $table->timestamp('created_at')->useCurrent();

      $table->index('conversation_id');
      $table->index('sender_id');
      $table->index('status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('messages');
  }
};
