<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonorStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donor_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('last_monthly_donor_donation')->nullable(); // price
            $table->decimal('last_once_donor_donation')->nullable(); // price
            $table->date('last_monthly_donor_date')->nullable();
            $table->date('last_once_donor_date')->nullable();
            $table->decimal('donation_sum')->nullable();
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
