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
    Schema::create('teacher_permissions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('permission_id');
      $table->unsignedBigInteger('teacher_id'); // only once!
      $table->timestamps();

      // Foreign keys
      $table->foreign('permission_id')
        ->references('id')->on('permissions')
        ->onDelete('cascade');

      $table->foreign('teacher_id')
        ->references('id')->on('companies')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('teacher_permissions');
  }
};
