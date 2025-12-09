<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * ------------------------------------------------------------
         * 1) COURSES TABLE UPDATES
         * ------------------------------------------------------------
         */

        // Convert ENUM → STRING (class_mode, course_type, class_type)
        DB::statement("ALTER TABLE courses MODIFY class_mode VARCHAR(50) NULL;");
        DB::statement("ALTER TABLE courses MODIFY course_type VARCHAR(50) NULL;");
        DB::statement("ALTER TABLE courses MODIFY class_type VARCHAR(50) NULL;");

        // Add new column
        Schema::table('courses', function (Blueprint $table) {
            $table->mediumText('notes')->nullable()->after('description');
        });

        /**
         * ------------------------------------------------------------
         * 2) COURSE_CLASSES TABLE UPDATES
         * ------------------------------------------------------------
         */

        // Convert ENUM → STRING
        DB::statement("ALTER TABLE course_classes MODIFY type VARCHAR(50) NULL;");
        DB::statement("ALTER TABLE course_classes MODIFY class_mode VARCHAR(50) NULL;");

        // Remove teacher_id (unique & foreign key)
        Schema::table('course_classes', function (Blueprint $table) {
            if (Schema::hasColumn('course_classes', 'teacher_id')) {
                $table->dropForeign(['teacher_id']);
                $table->dropColumn('teacher_id');
            }

            // Remove recording available
            if (Schema::hasColumn('course_classes', 'is_recording_available')) {
                $table->dropColumn('is_recording_available');
            }

            // Add notes column
            $table->mediumText('notes')->nullable()->after('description');

            // Change time → timestamp
            $table->timestamp('start_time')->nullable()->change();
            $table->timestamp('end_time')->nullable()->change();
        });

        /**
         * ------------------------------------------------------------
         * 3) COURSE_CLASS_PERMISSIONS TABLE
         * ------------------------------------------------------------
         */
        Schema::table('course_class_permissions', function (Blueprint $table) {
            $table->boolean('allow_poll')->default(0)->after('allow_chat');
            $table->boolean('allow_doubts')->default(0)->after('allow_poll');
        });

        /**
         * ------------------------------------------------------------
         * 4) NEW TABLE: teacher_classes
         * ------------------------------------------------------------
         */
        Schema::create('teacher_classes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('class_id'); // course_classes.id

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('class_id')->references('id')->on('course_classes')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Reverse ENUM conversions → optional (not required)
        // Delete new table
        Schema::dropIfExists('teacher_classes');

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('notes');
        });

        Schema::table('course_classes', function (Blueprint $table) {
            $table->dropColumn('notes');
        });

        Schema::table('course_class_permissions', function (Blueprint $table) {
            $table->dropColumn(['allow_poll', 'allow_doubts']);
        });
    }
};
