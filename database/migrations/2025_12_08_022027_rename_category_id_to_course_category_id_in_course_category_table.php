<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_category', function (Blueprint $table) {
            $table->renameColumn('category_id', 'course_category_id');
        });
    }

    public function down(): void
    {
        Schema::table('course_category', function (Blueprint $table) {
            $table->renameColumn('course_category_id', 'category_id');
        });
    }
};
