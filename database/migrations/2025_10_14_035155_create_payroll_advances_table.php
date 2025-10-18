<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payroll_advances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('reason')->nullable();
            $table->date('date')->nullable();
            $table->boolean('is_deducted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payroll_advances');
    }
};
