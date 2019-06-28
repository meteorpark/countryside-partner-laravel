<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cp_sns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sns_type')->comment('twitter, naverblog');
            $table->string('url');
            $table->longText('text');
            $table->string('text_created_at');
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
        Schema::dropIfExists('cp_sns');
    }
}
