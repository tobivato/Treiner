<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');  //can be for coach or player
            $table->string('role_type');            //either 'Treiner\Coach' or 'Treiner\Player'

            $table->string('first_name', 254);
            $table->string('last_name', 254);
            $table->string('email', 254)->unique();
            $table->string('phone', 32)->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say']);
            $table->enum('notification_preference', ['email', 'text'])->default('email');
            $table->string('password');
            $table->char('currency', 3);
            $table->string('image_id');
            $table->date('dob');
            $table->datetime('email_verified_at')->nullable();
            $table->datetime('phone_verified_at')->nullable();
            $table->enum('permissions', ['user', 'admin', 'super_admin'])->default('user');
            $table->timestamps();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
