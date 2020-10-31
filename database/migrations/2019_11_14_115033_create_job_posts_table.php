<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('location_id');
            $table->dateTime('starts');
            $table->text('details');
            $table->unsignedInteger('fee');
            $table->string('type', 127);
            $table->integer('length');
            $table->uuid('idempotency_key'); //used to ensure that Stripe transactions cannot happen twice
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
}
