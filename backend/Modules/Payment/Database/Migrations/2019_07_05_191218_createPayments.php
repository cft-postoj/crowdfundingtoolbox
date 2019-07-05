<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payment');
        Schema::create('payments', function (Blueprint $table) {
        $table->increments('id');
        $table->bigInteger('donation_id')->nullable();
        $table->foreign('donation_id')->references('id')->on('donations');
        $table->string('transaction_id')->nullable();
        $table->string('variable_symbol')->nullable();
        $table->string('iban')->nullable();
        $table->decimal('amount');
        $table->string('transfer_type')->nullable();
        $table->date('transaction_date');
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
        Schema::dropIfExists('payments');
    }
}
