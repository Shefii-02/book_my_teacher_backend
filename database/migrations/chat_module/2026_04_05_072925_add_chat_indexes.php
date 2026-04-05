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
          // messages table
        Schema::table('messages', function (Blueprint $table) {
            $table->index('conversation_id', 'idx_messages_conv_id');
            $table->index('sender_id', 'idx_messages_sender');
        });

        // message_reads table
        Schema::table('message_reads', function (Blueprint $table) {
            $table->index(['message_id', 'user_id'], 'idx_message_reads_msg_user');
        });

        // conversation_members table
        Schema::table('conversation_members', function (Blueprint $table) {
            $table->index('user_id', 'idx_conv_members_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // messages table
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('idx_messages_conv_id');
            $table->dropIndex('idx_messages_sender');
        });

        // message_reads table
        Schema::table('message_reads', function (Blueprint $table) {
            $table->dropIndex('idx_message_reads_msg_user');
        });

        // conversation_members table
        Schema::table('conversation_members', function (Blueprint $table) {
            $table->dropIndex('idx_conv_members_user');
        });
    }
};
