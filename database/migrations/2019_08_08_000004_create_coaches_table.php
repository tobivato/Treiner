<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('club')->nullable();
            $table->boolean('is_company')->default(0);
            $table->string('business_registration_number')->nullable(); //ABN etc
            $table->enum('qualification', config('treiner.qualifications'));
            $table->tinyInteger('years_coaching');
            $table->tinyInteger('treiner_fee')->default(10); //the percentage of the sale that Treiner takes
            $table->string('stripe_token')->nullable();
            $table->json('age_groups_coached');
            $table->json('session_types');
            $table->text('profile_summary');
            $table->text('profile_session');
            $table->text('profile_philosophy');
            $table->text('profile_playing');
            $table->enum('verification_status', ['pending', 'verified', 'denied'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coaches');
    }
}
