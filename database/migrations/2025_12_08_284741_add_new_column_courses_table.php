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
    Schema::create('institutes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->unsignedBigInteger('company_id')->nullable();
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();

      $table->unique(['user_id', 'company_id']);
    });

    Schema::table('courses', function (Blueprint $table) {
      //
      $table->integer('commission_percentage')->default(0)->after('created_by');
      $table->unsignedBigInteger('institude_id')->nullable()->after('position');
      $table->foreign('institude_id')->references('id')->on('users')->onDelete('cascade');
    });


  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
