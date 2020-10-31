<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPromotionCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('promotion_codes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('promotion_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->unsignedBigInteger('coach_id');
            $table->integer('maximum');
            $table->tinyInteger('percentage');

            $table->timestamps();

            $table->index('coach_id');
            $table->foreign('coach_id')->references('id')->on('coaches');
        });

        Schema::create('promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('promotion_code_id');

            $table->index('player_id');
            $table->index('promotion_code_id');

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('promotion_code_id')->references('id')->on('promotion_codes');
        });
    }
}
