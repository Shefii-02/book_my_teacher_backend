<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {

    Schema::table('purchase_payments', function (Blueprint $table) {
      //
      $table->string('reference_id', 250)->nullable();
      $table->dateTime('processing_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
      $table->longText('response_msg')->nullable();
      $table->string('merchantOrderId')->nullable();
      $table->string('checksum')->nullable();
      $table->string('payment_method', 50)->nullable();
      $table->string('utr')->nullable()->comment('upi');
      $table->string('card_type', 50)->nullable()->comment('card');
      $table->string('arn')->nullable()->comment('card');
      $table->string('pg_authorization_code')->nullable()->comment('card');
      $table->string('pg_transaction_id')->nullable()->comment('netbankig,card');
      $table->string('bank_transaction_id')->nullable()->comment('netbankig,card');
      $table->string('bank_id')->nullable()->comment('netbankig,card');
      $table->string('pg_service_transaction_id')->nullable()->comment('netbankig');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {}
};
