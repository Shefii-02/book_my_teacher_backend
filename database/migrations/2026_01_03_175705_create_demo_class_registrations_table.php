<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('demo_class_registrations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('class_id')->constrained('demo_classes')->cascadeOnDelete();
      $table->foreignId('user_id')->nullable(); // optional link to users table
      $table->string('name');
      $table->string('email');
      $table->string('phone')->nullable();
      $table->boolean('checked_in')->default(false);
      $table->unique(['class_id', 'user_id']); // single registration per email per webinar
      $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('demo_class_registrations');
  }
};
