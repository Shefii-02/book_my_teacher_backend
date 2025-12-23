<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('workshop_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained('workshops')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable(); // optional link to users table
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->boolean('checked_in')->default(false);
            $table->timestamps();

            $table->unique(['workshop_id', 'user_id']); // single registration per email per workshop
        });
    }

    public function down()
    {
        Schema::dropIfExists('workshop_registrations');
    }

}
