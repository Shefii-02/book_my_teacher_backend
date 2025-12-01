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
    //
    Schema::create('wallet_histories', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');

      // green / rupee
      $table->enum('wallet_type', ['green', 'rupee']);

      $table->string('title');               // e.g. Completed Demo Class
      $table->enum('type', ['credit', 'debit']); // credit/debit
      $table->integer('amount');            // amount
      $table->string('status');             // Approved / Pending etc.
      $table->date('date');                 // activity date
      $table->mediumText('notes')->nullable();
      $table->timestamps();

      // relation
      $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
            Schema::dropIfExists('wallet_histories');
  }
};
