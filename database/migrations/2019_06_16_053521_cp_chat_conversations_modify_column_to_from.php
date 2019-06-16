<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CpChatConversationsModifyColumnToFrom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cp_chat_conversations', function (Blueprint $table) {
            $table->string('to')->change();
            $table->string('from')->change();
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
            $table->integer('to')->change();
            $table->integer('from')->change();
        });
    }
}
