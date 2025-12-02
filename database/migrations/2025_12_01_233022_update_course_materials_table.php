<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('course_materials', function (Blueprint $table) {
        $table->integer('position')->default(1)->after('course_id');
        $table->enum('status', ['draft', 'published'])->default('published')->after('position');
        $table->string('file_type')->nullable()->after('file_path');
    });
}

public function down()
{
    Schema::table('course_materials', function (Blueprint $table) {
        $table->dropColumn(['position', 'status', 'file_type']);
    });
}

};
