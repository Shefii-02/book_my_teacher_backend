<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->foreignId('provider_app_id')->nullable()->after('stream_provider_id')->constrained('credentials')->nullOnDelete();
        });

        Schema::table('webinar_registrations', function (Blueprint $table) {
            $table->boolean('attended_status')->default(false)->after('checked_in');
        });
    }

    public function down()
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropForeign(['provider_app_id']);
            $table->dropColumn('provider_app_id');
        });

        Schema::table('webinar_registrations', function (Blueprint $table) {
            $table->dropColumn('attended_status');
        });
    }
};
