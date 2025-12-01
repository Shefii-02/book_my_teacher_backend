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
    Schema::create('top_banners', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->longText('description')->nullable();
      $table->string('thumb_id')->nullable();
      $table->string('main_id')->nullable();
      $table->integer('priority')->default(1);
      $table->string('banner_type')->default('top-banner');
      $table->string('ct_label')->nullable();
      $table->string('ct_action')->nullable();
      $table->boolean('status')->default(true);
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('top_banners');
  }
};
