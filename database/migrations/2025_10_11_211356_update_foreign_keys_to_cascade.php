<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    // course_category pivot table
    Schema::table('course_categories', function (Blueprint $table) {
      $table->dropForeign(['company_id']);

      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
    });

    Schema::table('course_sub_categories', function (Blueprint $table) {
      $table->dropForeign(['company_id']);

      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
    });


    Schema::table('courses', function (Blueprint $table) {
      $table->dropForeign(['company_id']);

      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
    });


    Schema::table('webinars', function (Blueprint $table) {
      $table->dropForeign(['company_id']);

      $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
    });



    // course_classes table
    Schema::table('course_classes', function (Blueprint $table) {
      $table->dropForeign(['course_id']);
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
    });

    // subjects (optional)
    Schema::table('subjects', function (Blueprint $table) {
      $table->dropForeign(['grade_id']);
      $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
    });

    info('✅ Foreign keys updated to use ON DELETE CASCADE where appropriate.');
  }

  public function down(): void
  {

    Schema::table('course_categories', function (Blueprint $table) {
      $table->dropForeign(['company_id']);
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
    });

    Schema::table('course_sub_categories', function (Blueprint $table) {
      $table->dropForeign(['company_id']);
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
    });

    Schema::table('courses', function (Blueprint $table) {
      $table->dropForeign(['company_id']);
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
    });

    Schema::table('webinars', function (Blueprint $table) {
      $table->dropForeign(['company_id']);
      $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
    });



    Schema::table('course_classes', function (Blueprint $table) {
      $table->dropForeign(['course_id']);
      $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
    });

    Schema::table('subjects', function (Blueprint $table) {
      $table->dropForeign(['grade_id']);
      $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
    });
  }
};
