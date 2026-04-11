<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('app_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('app_reviews', 'position')) {
                $table->integer('position')->default(0)->after('show_dispaly');
            }
            $table->renameColumn('show_dispaly', 'company_id')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_reviews', function (Blueprint $table) {
            if (Schema::hasColumn('app_reviews', 'position')) {
                $table->dropColumn('position');
            }

            $table->renameColumn('company_id', 'show_dispaly')->nullable(true)->change();
        });
    }
};
