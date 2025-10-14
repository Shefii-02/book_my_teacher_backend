<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('salary_type', ['monthly', 'hourly'])->default('monthly');
            $table->decimal('basic_salary', 10, 2)->nullable();   // For monthly
            $table->decimal('hourly_rate', 10, 2)->nullable();    // For hourly
            $table->decimal('allowances', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('total_hours', 8, 2)->nullable();     // If hourly
            $table->decimal('final_salary', 10, 2)->nullable();
            $table->date('joining_date')->nullable();
            $table->string('payment_mode')->nullable(); // bank, cash, upi
            $table->string('payroll_type')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payroll_details');
    }
};
