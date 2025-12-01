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
        Schema::create('app_referrals', function (Blueprint $table) {
            $table->id();
            $table->string('referral_code'); // N5FHD27Q
            $table->string('device_hash')->nullable();
            $table->string('ip')->nullable();
            $table->text('ua')->nullable();
            $table->datetime('first_visit')->nullable();
            $table->datetime('last_visit')->nullable();
            $table->boolean('applied')->default(false);
            $table->unsignedBigInteger('applied_user_id')->nullable(); // student/teacher who applied
            $table->unsignedBigInteger('ref_user_id')->nullable(); // original referrer user
            $table->enum('status', ['active','blocked','credited','pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_referrals');
    }
};
