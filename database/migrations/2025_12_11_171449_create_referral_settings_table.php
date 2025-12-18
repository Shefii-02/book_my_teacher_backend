<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referral_settings', function (Blueprint $table) {
            $table->id();
                 $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->integer('reward_per_join')->default(100);
            $table->integer('bonus_on_first_class')->default(250);

            $table->string('how_it_works')->nullable();
            $table->text('how_it_works_description')->nullable();

            $table->string('badge_title')->nullable();
            $table->text('badge_description')->nullable();

            $table->text('share_link_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_settings');
    }
};
