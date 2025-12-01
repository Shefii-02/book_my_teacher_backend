<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('providing_subjects', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('company_id');
      $table->unsignedBigInteger('subject_id');
      $table->integer('position')->default(0);
      $table->timestamps();

      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

      $table->unique(['company_id', 'subject_id']);
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
