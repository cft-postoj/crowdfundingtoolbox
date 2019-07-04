<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationsAlter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->renameColumn('donation', 'amount');
            $table->integer('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('payment');
            $table->enum('status', ['initialized', 'waiting_for_payment', 'processed'])->nullable();
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
