<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionPlayerToReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['session_id']);
            $table->dropForeign(['player_id']);
            
            $table->dropIndex(['session_id']);
            $table->dropIndex(['player_id']);

            $table->dropColumn('session_id');
            $table->dropColumn('player_id');

            $table->unsignedBigInteger('session_player_id');

            $table->foreign('session_player_id')->references('id')->on('session_players');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('player_id');
        
            $table->index('session_id');
            $table->index('player_id');
        
            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('session_id')->references('id')->on('sessions');
        });
    }
}
