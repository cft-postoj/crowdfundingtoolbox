<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreatedUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('created_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');

            $table->integer('donation_id');
            $table->foreign('donation_id')->references('id')->on('donations');

            $table->timestamp('send_mail_at');
            $table->timestamp('email_was_sent_at')->nullable();

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
        //
    }
}
