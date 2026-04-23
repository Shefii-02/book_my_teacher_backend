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
    Schema::connection('mysql2')->table('message_reads', function (Blueprint $table) {

      if (!Schema::connection('mysql2')
        ->hasColumn('message_reads', 'conversation_id')) {

        $table->unsignedBigInteger('conversation_id')->nullable();
        $table->index('conversation_id');
      }

      if (!Schema::connection('mysql2')
        ->hasColumn('message_reads', 'read_at')) {

        $table->timestamp('read_at')->nullable();
      }

      if (!Schema::connection('mysql2')
        ->hasColumn('message_reads', 'status')) {

        $table->tinyInteger('status')
          ->default(0)
          ->nullable();

          $table->timestamps();
      }

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::connection('mysql2')->table('message_reads', function (Blueprint $table) {

      $table->dropIndex(['conversation_id']);

      $table->dropColumn([
        'conversation_id',
        'read_at',
        'status'
      ]);
    });
  }
};
