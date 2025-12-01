<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

        //
       public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {

            // ---- DROP FOREIGN KEY FIRST ----
            if (Schema::hasColumn('subjects', 'grade_id')) {

                // Drop FK constraint safely
                $table->dropForeign(['grade_id']);

                // Drop the actual column
                $table->dropColumn('grade_id');
            }

            // ---- ADD NEW COLUMNS ----
            if (!Schema::hasColumn('subjects', 'icon')) {
                $table->string('icon')->nullable()->after('value');
            }

            if (!Schema::hasColumn('subjects', 'color_code')) {
                $table->string('color_code')->default('#2d6cdf')->after('icon');
            }

            if (!Schema::hasColumn('subjects', 'difficulty_level')) {
                $table->string('difficulty_level')
                    ->comment("['Easy','Medium','Hard']")
                    ->after('color_code');
            }

            if (!Schema::hasColumn('subjects', 'position')) {
                $table->integer('position')->default(0)->after('difficulty_level');
            }

            if (!Schema::hasColumn('subjects', 'published')) {
                $table->boolean('published')->default(1)->after('position');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('subjects', function (Blueprint $table) {

            // Re-create the old column
            if (!Schema::hasColumn('subjects', 'grade_id')) {
                $table->unsignedBigInteger('grade_id')->nullable()->after('value');
                $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
            }

            // Drop added columns
            $table->dropColumn([
                'icon',
                'color_code',
                'difficulty_level',
                'position',
                'published',
            ]);
        });
    }
};
