<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('teacher_courses', function (Blueprint $table) {


    // Drop unique composite key
    // $table->dropUnique('teacher_courses_teacher_id_course_id_unique');

    // Make teacher nullable
    // $table->unsignedBigInteger('teacher_id')->nullable()->change();
    });
  }




  public function down()
  {
    Schema::table('teacher_courses', function (Blueprint $table) {});
  }
};
