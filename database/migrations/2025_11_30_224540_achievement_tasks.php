<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('achievement_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_level_id')->constrained('achievement_levels')->cascadeOnDelete();
            $table->string('task_type')->comment('e.g. referral_count,youtube_upload,profile_complete');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('target_value')->default(1);
            $table->integer('points')->default(0);
            $table->integer('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('achievement_tasks');
    }
};
