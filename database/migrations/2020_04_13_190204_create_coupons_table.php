<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->string('code');
            $table->unsignedTinyInteger('percent_off')->default(0);
            $table->integer('amount_off')->default(0);
            $table->unsignedTinyInteger('times_redeemable_per_person')->default(1);
            $table->unsignedInteger('times_redeemable_total');
            $table->unsignedBigInteger('coach_id')->nullable();
            $table->dateTime('redeem_by');
            $table->string('currency', 3);

            $table->primary('code');
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
        Schema::dropIfExists('coupons');
    }
}
