<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedTinyInteger('players');
            $table->timestamps();
            $table->uuid('idempotency_key'); //used to ensure that Stripe transactions cannot happen twice

            $table->index('player_id');
            $table->index('session_id');

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
        Schema::dropIfExists('cart_items');
    }
}
