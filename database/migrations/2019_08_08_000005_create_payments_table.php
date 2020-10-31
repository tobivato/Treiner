<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('billing_address_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('coach_id');
            $table->integer('amount');
            $table->char('currency', 3);
            $table->string('charge_id', 63);
            $table->timestamps();

            $table->foreign('billing_address_id')->references('id')->on('billing_addresses');
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('coach_id')->references('id')->on('coaches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
