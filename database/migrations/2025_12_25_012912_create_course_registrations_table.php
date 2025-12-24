<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable(); // optional link to users table
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->boolean('checked_in')->default(false);
            $table->timestamps();

            $table->unique(['course_id', 'user_id']); // single registration per email per webinar
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_registrations');
    }

}
