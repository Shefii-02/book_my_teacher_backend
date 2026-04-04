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
    Schema::connection($this->connection)->create('users', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->unique();
      $table->string('name')->nullable();
      $table->string('email')->nullable();
      $table->string('mobile')->nullable();
      $table->unsignedBigInteger('company_id')->nullable();
      $table->string('role')->nullable();
      $table->text('avatar_url')->nullable();

      $table->boolean('is_online')->default(false);
      $table->dateTime('last_seen')->nullable();
      $table->string('socket_id')->nullable();

      $table->timestamp('created_at')->useCurrent();
      $table->softDeletes();

      // Indexes
      $table->index('user_id');
      $table->index('company_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
