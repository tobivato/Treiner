<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coach_id');
            $table->unsignedBigInteger('location_id');
            $table->dateTime('starts');
            $table->integer('length'); //length in minutes
            $table->unsignedInteger('fee');
            $table->tinyInteger('group_min');
            $table->tinyInteger('group_max');
            $table->string('type', 127);
            $table->enum('status', ['scheduled', 'completed'])->default('scheduled');
            $table->softDeletes();
            $table->timestamps();
            $table->string('zoom_number')->nullable();

            $table->index('coach_id');
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('sessions');
    }
}
