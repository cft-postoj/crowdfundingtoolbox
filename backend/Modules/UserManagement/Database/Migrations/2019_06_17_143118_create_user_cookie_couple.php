<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCookieCouple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cookie_couple', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->integer('user_cookie_id');
            $table->foreign('user_cookie_id')->references('id')->on('user_cookie');
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
        Schema::dropIfExists('couple_user_with_cookie');
    }
}
