<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('subject_reviews', function (Blueprint $table) {

      // $table->dropUnique('subject_reviews_subject_id_foreign');
      // $table->string('subject_id')->nullable()->change();
      // $table->dropForeign('subject_reviews_subject_course_id_foreign');

      // $table->dropUnique('subject_reviews_subject_course_id_foreign');
      // $table->renameColumn('subject_course_id', 'course_id');

    });
  }

  public function down()
  {
    Schema::table('subject_reviews', function (Blueprint $table) {});
  }
};
