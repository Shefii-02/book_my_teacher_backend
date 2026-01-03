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
            $table->dropForeign('courses_institude_id_foreign');

            // 2. Drop UNIQUE constraint (IMPORTANT)
            $table->dropUnique('courses_institude_id_unique');

            // 3. Change column type
            $table->string('institude_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // 4. Revert column type
            $table->unsignedBigInteger('institude_id')->change();

            // 5. Restore UNIQUE constraint
            $table->unique('institude_id');

            // 6. Restore FOREIGN KEY
            $table->foreign('institude_id')
                  ->references('id')
                  ->on('institudes')
                  ->onDelete('cascade');
        });
    }
};
