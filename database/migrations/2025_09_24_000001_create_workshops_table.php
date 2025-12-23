<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    public function up()
    {
        /**
         * Workshops table
         */
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('slug')->unique();

            // Images / Media
            $table->string('thumbnail_image')->nullable();
            $table->string('main_image')->nullable();

            $table->foreignId('stream_provider_id')->constrained('stream_providers')->onDelete('cascade');

               // Host (link to users table)
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');

            // Scheduling
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->dateTime('registration_end_at')->nullable();

            // Access & roles
            $table->boolean('is_teacher_allowed')->default(true);
            $table->boolean('is_student_allowed')->default(true);
            $table->boolean('is_guest_allowed')->default(false);
            $table->integer('max_participants')->nullable();

            // Features
            $table->boolean('is_record_enabled')->default(false);
            $table->boolean('is_chat_enabled')->default(true);
            $table->boolean('is_screen_share_enabled')->default(true);
            $table->boolean('is_whiteboard_enabled')->default(false);
            $table->boolean('is_camera_enabled')->default(false);
            $table->boolean('is_audio_only_enabled')->default(false);

            // Status
            $table->enum('status', ['draft', 'scheduled', 'live', 'ended'])->default('draft');
            $table->boolean('is_public')->default(true);

            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->nullOnDelete();

            $table->timestamps();
        });

        /**
         * Workshop classes table
         */
        Schema::create('workshop_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('workshop_id')
                ->constrained('workshops')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // class type: live / recorded / hybrid
            $table->string('type')->nullable();

            $table->date('scheduled_at')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Online / Offline / Hybrid
            $table->string('class_mode')->nullable();

            // Meeting info
            $table->string('meeting_link')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->string('recording_url')->nullable();

            $table->integer('priority')->default(0);

            $table->enum('status', ['draft', 'scheduled', 'completed', 'cancelled'])
                ->default('draft');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workshop_classes');
        Schema::dropIfExists('workshops');
    }
}
