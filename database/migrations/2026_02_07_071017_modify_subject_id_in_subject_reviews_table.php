<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('subject_reviews', function (Blueprint $table) {

            // 🔥 Drop foreign key
            $table->dropForeign('subject_reviews_subject_id_foreign');

            // 🔥 Drop index
            $table->dropIndex(['subject_id']);

            // 🔥 Change datatype
            $table->string('subject_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('subject_reviews', function (Blueprint $table) {

            // rollback datatype
            $table->unsignedBigInteger('subject_id')->change();

            // restore index
            $table->index('subject_id');

            // restore foreign key
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('cascade');
        });
    }
};
