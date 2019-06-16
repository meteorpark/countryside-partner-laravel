<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCpChatListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cp_chat_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('constructor'); // mentor|mentor_srl or mentee|mentee_srl
            $table->string('participants'); // mentor|mentor_srl or mentee|mentee_srl
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cp_chat_lists');
    }
}
