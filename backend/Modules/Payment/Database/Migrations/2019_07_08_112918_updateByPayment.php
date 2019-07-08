<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateByPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('transfer_type');
            $table->dropColumn('variable_symbol');
            $table->dropColumn('transaction_date');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->integer('transfer_type');
            $table->foreign('transfer_type')->references('id')->on('payment_methods');
            $table->bigInteger('variable_symbol')->nullable();
            $table->timestamp('transaction_date');
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
