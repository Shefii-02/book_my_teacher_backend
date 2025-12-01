<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('teachers', function (Blueprint $table) {
      $table->id();

      $table->string('thumb')->nullable();
      $table->string('main')->nullable();

      $table->string('name');
      $table->string('qualifications')->nullable();
      $table->longText('bio')->nullable();

      $table->json('speaking_languages')->nullable();
      $table->decimal('price_per_hour', 10, 2)->default(0);
      $table->integer('year_exp')->default(0);

      $table->boolean('commission_enabled')->default(false);
      $table->integer('commission_percent')->nullable();

      $table->string('demo_class_link')->nullable();

      $table->json('certificates')->nullable();

      $table->boolean('include_top_teachers')->default(false);

      $table->json('subjects')->nullable();

      $table->json('time_slots')->nullable();

      $table->boolean('published')->default(true);

      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('teachers');
  }
};
