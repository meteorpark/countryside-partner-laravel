<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCpChatConversations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cp_chat_conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_lists_id');
            $table->longText('contents');
            $table->bigInteger('to'); // // mentor|mentor_srl or mentee|mentee_srl
            $table->bigInteger('from'); // // mentor|mentor_srl or mentee|mentee_srl
            $table->timestamps();
            $table->foreign('chat_lists_id')->
            references('id')->
            on('cp_chat_lists')->
            onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cp_chat_conversations');
    }
}
