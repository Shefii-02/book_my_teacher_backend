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
        Schema::create('teacher_payment_transfers', function (Blueprint $table) {

            $table->id();

            // Teacher
            $table->foreignId('teacher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Transfer Details
            $table->string('transfer_no')->unique();

            $table->decimal('amount', 12, 2)->default(0);

            $table->decimal('charge_amount', 12, 2)->default(0);

            $table->decimal('final_amount', 12, 2)->default(0);

            // Transfer Method
            $table->enum('transfer_method', [
                'bank',
                'upi',
                'paypal',
                'stripe',
                'razorpay'
            ])->nullable();

            // Bank / UPI Details
            $table->string('bank_name')->nullable();

            $table->string('account_holder_name')->nullable();

            $table->string('account_number')->nullable();

            $table->string('ifsc_code')->nullable();

            $table->string('upi_id')->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'rejected'
            ])->default('pending');

            // Admin
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Transaction
            $table->string('reference_no')->nullable();

            $table->text('remarks')->nullable();

            // Dates
            $table->timestamp('requested_at')->nullable();

            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            // Index
            $table->index('teacher_id');
            $table->index('status');
            $table->index('transfer_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_payment_transfers');
    }
};
