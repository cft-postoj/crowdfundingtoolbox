<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPaymentOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_payment_options', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->string('bank_account_number')->nullable();
            $table->string('payment_card_number')->nullable();
            $table->string('payment_card_expiration_date')->nullable();
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
