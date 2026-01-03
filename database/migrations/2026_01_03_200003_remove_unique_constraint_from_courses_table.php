<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {



            // 1. Drop foreign key
            // $table->dropForeign('courses_institude_id_foreign');

            // // 2. Drop unique constraint
            // $table->dropUnique('courses_institude_id_unique');

            // 3. Drop the column completely
            $table->dropColumn('is_public');
        });

        Schema::table('courses', function (Blueprint $table) {
            // 4. Recreate column with same name (NO unique, NO FK)
            $table->boolean('is_public')->default(1)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {

            // 5. Drop recreated column
            $table->dropColumn('is_public');
        });

        Schema::table('courses', function (Blueprint $table) {

            // 6. Restore original column
            $table->unsignedBigInteger('is_public');


        });
    }
};
