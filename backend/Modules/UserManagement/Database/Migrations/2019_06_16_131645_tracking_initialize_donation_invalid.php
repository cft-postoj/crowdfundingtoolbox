<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrackingInitializeDonationInvalid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_donation_initialize_invalid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('show_id');
            $table->foreign('show_id')->references('id')->on('tracking_show');
            $table->string('email')->nullable();
            $table->boolean('terms')->nullable();
            //TODO; frequency - replace with enum
            $table->string('frequency')->nullable();
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
