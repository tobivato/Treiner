<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('coupon_id');
            $table->unsignedBigInteger('player_id');
            $table->timestamps();
            
            $table->foreign('coupon_id')->references('code')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_players');
    }
}
