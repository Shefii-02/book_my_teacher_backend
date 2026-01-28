<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {

    Schema::table('companies', function (Blueprint $table) {
      $table->integer('is_allow_courses')->default(1)->nullable();
      $table->integer('is_allow_workshop')->default(1)->nullable();
      $table->integer('workshop_classes_limits')->default(1)->nullable();
      $table->integer('is_allow_webinar')->default(1)->nullable();
    });

    Schema::table('courses', function (Blueprint $table) {
      $table->unsignedBigInteger('updated_by')->nullable()->after('status')->index();
      $table->foreign('updated_by')->references('id')->on('users')->cascadeOnUpdate();
    });


    Schema::table('course_classes', function (Blueprint $table) {
      $table->unsignedBigInteger('created_by')->nullable()->after('status')->index();
      $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
      $table->unsignedBigInteger('updated_by')->nullable()->after('status')->index();
      $table->foreign('updated_by')->references('id')->on('users')->cascadeOnUpdate();
    });

    Schema::table('course_materials', function (Blueprint $table) {
      $table->unsignedBigInteger('created_by')->nullable()->after('status')->index();
      $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
      $table->unsignedBigInteger('updated_by')->nullable()->after('status')->index();
      $table->foreign('updated_by')->references('id')->on('users')->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
