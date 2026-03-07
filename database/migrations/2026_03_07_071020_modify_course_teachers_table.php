<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('teacher_classes', function (Blueprint $table) {


      // Drop unique composite key
      // $table->dropForeign(['teacher_id']);
      $table->dropUnique('teacher_classes_teacher_id_foreign');
      $table->dropUnique(['teacher_id']);
    });
  }




  public function down()
  {
    Schema::table('teacher_classes', function (Blueprint $table) {});
  }
};
