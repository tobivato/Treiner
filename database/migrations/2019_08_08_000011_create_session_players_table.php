<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('payment_id');
            $table->boolean('review_email_sent')->default(false);
            $table->boolean('reviewed');
            $table->json('player_info');
            $table->integer('players');

            $table->index('player_id');
            $table->index('session_id');
            $table->index('payment_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('session_id')->references('id')->on('sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_players');
    }
}
