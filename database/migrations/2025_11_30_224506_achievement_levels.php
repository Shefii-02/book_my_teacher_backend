<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('achievement_levels', function (Blueprint $table) {
      $table->id();
      $table->string('role')->comment('teacher|student|staff');
      $table->integer('level_number')->default(1);
      $table->string('title');
      $table->text('description')->nullable();
      $table->boolean('is_active')->default(true);
      $table->integer('position')->default(0);
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();

      $table->unique(['role', 'level_number']);
    });
  }
  public function down()
  {
    Schema::dropIfExists('achievement_levels');
  }
};
