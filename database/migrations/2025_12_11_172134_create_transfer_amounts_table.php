<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transfer_amounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->decimal('transfer_amount', 12, 2);
            $table->string('transaction_source')->nullable();     // ex: wallet, commission, recharge
            $table->string('transaction_method')->nullable();     // ex: bank, upi, cheque

            // BANK DETAILS
            $table->string('transfer_to_account_no')->nullable();
            $table->string('transfer_to_ifsc_no')->nullable();
            $table->string('transfer_holder_name')->nullable();

            // UPI DETAILS
            $table->string('transfer_upi_id')->nullable();
            $table->string('transfer_upi_number')->nullable();

            // INTERNAL
            $table->unsignedBigInteger('transferred_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->enum('status', ['pending','approved','rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_amounts');
    }
};
