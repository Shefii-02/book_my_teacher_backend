<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teacher_subject_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->decimal('rate_0_10', 10, 2)->nullable();
            $table->decimal('rate_10_30', 10, 2)->nullable();
            $table->decimal('rate_30_plus', 10, 2)->nullable();
            $table->timestamps();

            $table->unique(['teacher_id','subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_subject_rates');
    }
};
