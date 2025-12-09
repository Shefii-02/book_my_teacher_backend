<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->boolean('is_active')->default(1)->after('offer_code');
            $table->unsignedInteger('max_usage_count')->nullable()->after('is_active'); // NULL = unlimited usage
            $table->unsignedInteger('current_usage_count')->default(0)->after('max_usage_count');
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'max_usage_count', 'current_usage_count']);
        });
    }
};
