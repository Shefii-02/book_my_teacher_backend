<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('course_registrations', function (Blueprint $table) {

        $table->dropForeign(['course_id']);
        $table->dropForeign(['user_id']);
        $table->dropUnique('course_id');
        $table->dropUnique('user_id');
        // $table->integer('course_id')->nullable()->after('id');
      // Drop unique composite key
      // $table->dropForeign(['course_id']);
      // $table->dropColumn('teacher_id');
      // $table->integer('teacher_id')->nullable()->after('id');
    });
  }




  public function down()
  {
    Schema::table('teacher_classes', function (Blueprint $table) {});
  }
};
