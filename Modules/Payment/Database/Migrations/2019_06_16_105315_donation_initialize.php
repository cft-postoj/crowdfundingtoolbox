<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationInitialize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_initialize', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_id');
            $table->foreign('show_id')->references('id')->on('tracking_show');
            $table->string('email');
            $table->integer('terms');
            //TODO; frequency - replace with enum
            $table->string('frequency');
            $table->float('donation_value');
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
