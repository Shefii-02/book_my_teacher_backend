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
    Schema::connection($this->connection)->create('conversation_members', function (Blueprint $table) {
      $table->unsignedBigInteger('conversation_id');
      $table->unsignedBigInteger('user_id');
      $table->timestamp('joined_at')->useCurrent();

      $table->primary(['conversation_id', 'user_id']);

      $table->index('user_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('conversation_members');
  }
};
