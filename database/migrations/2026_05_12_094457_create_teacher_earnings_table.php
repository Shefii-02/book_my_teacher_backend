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
        Schema::create('teacher_earnings', function (Blueprint $table) {

            $table->id();

            // Teacher
            $table->foreignId('teacher_id')
                ->constrained('users')
                ->cascadeOnDelete();


            // Teacher
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title')->nullable();

            // Source Details
            $table->string('type')->comment('course / class / referral / subscription / demo / etc')->nullable();
            // course / class / referral / subscription / demo / etc

            $table->unsignedBigInteger('source_id')->nullable();

            // Payment Info
            $table->decimal('amount', 12, 2)->default(0);

            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'cancelled',
                'refunded'
            ])->default('pending');

            // Notes
            $table->text('remarks')->nullable();

            $table->timestamp('earned_at')->nullable();

            $table->timestamps();

            // Index
            $table->index('teacher_id');
            $table->index('created_by');
            $table->index('status');
            $table->index('source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_earnings');
    }
};
