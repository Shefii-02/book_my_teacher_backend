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
    Schema::connection($this->connection)->create('conversations', function (Blueprint $table) {
      $table->id();
      $table->enum('type', ['direct', 'group'])->default('direct');
      $table->string('name')->nullable();
      $table->text('avatar_url')->nullable();
      $table->unsignedBigInteger('created_by')->nullable();

      $table->timestamp('created_at')->useCurrent();
      $table->softDeletes();

      $table->index('created_by');
      $table->index('type');
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('conversations');
  }
};
