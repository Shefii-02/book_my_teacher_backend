<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::table('courses', function (Blueprint $table) {
      $table->integer('step_completed')->default(0); // 0 = not started, 1 = basic info done, etc.
    });
  }

  public function down() {}
};
