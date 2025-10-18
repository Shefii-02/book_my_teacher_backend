<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('webinar_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained('webinars')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable(); // optional link to users table
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->boolean('checked_in')->default(false);
            $table->timestamps();

            $table->unique(['webinar_id', 'user_id']); // single registration per email per webinar
        });
    }

    public function down()
    {
        Schema::dropIfExists('webinar_registrations');
    }

}
