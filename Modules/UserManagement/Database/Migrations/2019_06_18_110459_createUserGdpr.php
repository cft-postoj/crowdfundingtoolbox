<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGdpr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gdpr', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->boolean('agree_mail_sending')->default(false)->nullable();
            $table->boolean('agree_general_conditions')->default(false)->nullable();
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
        //
    }
}
