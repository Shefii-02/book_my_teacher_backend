<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up()
  {
    Schema::table('courses', function (Blueprint $table) {
      $table->string('tax_percentage')->nullable();
      $table->string('discount_validity')->nullable();
      $table->date('discount_validity_end')->nullable();
      $table->string('course_identity')->nullable();
    });
  }

  public function down() {}

};
