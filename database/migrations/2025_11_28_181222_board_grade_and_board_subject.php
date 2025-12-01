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

    Schema::create('boards', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('value');
      $table->mediumText('description');
      $table->string('icon');
      $table->integer('position')->default(0);
      $table->boolean('published')->default(1);
      $table->timestamps();
    });


    //
    Schema::create('board_grade', function (Blueprint $table) {
      $table->id();
      $table->foreignId('grade_id')->constrained()->cascadeOnDelete();
      $table->foreignId('board_id')->constrained()->cascadeOnDelete();
      $table->timestamps();
    });

    Schema::create('board_subject', function (Blueprint $table) {
      $table->id();
      $table->foreignId('board_id')->constrained()->cascadeOnDelete();
      $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
