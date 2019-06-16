<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CpChatConversationsRenameMessage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cp_chat_conversations', function (Blueprint $table) {
            $table->renameColumn('contents', 'message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cp_chat_conversations', function (Blueprint $table) {
            $table->renameColumn('message', 'contents');
        });
    }
}
