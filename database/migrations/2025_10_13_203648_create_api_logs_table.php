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
        Schema::create('api_logs', function (Blueprint $table) {
    $table->id();
    $table->string('endpoint');
    $table->string('method', 10);
    $table->json('headers')->nullable();
    $table->json('request_body')->nullable();
    $table->json('response_body')->nullable();
    $table->integer('status_code')->nullable();
    $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
    $table->string('ip_address')->nullable();
    $table->string('device_info')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
