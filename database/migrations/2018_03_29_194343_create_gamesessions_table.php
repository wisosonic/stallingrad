<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamesessions', function (Blueprint $table) {
            $table->increments('id');
            $table->text("enemies");
            $table->text("enemiesProto");
            $table->text("towers");
            $table->text("towersProto");
            $table->text("addedLife");
            $table->text("timer");
            $table->string("money");
            $table->string("stopped");
            $table->string("attackerPoints");
            $table->string("addEnemyTimer");
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('map_id')->unsigned()->index()->nullable();
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
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
        Schema::dropIfExists('gamesessions');
    }
}
