<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_slug');
            $table->string('method_name');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('payment_methods')->insert(
            array(
                array(
                    'method_slug' => 'bank-transfer',
                    'method_name' => 'Bank transfer'
                ),
                array(
                    'method_slug' => 'card',
                    'method_name' => 'Credit card'
                ),
                array(
                    'method_slug' => 'pay-by-square',
                    'method_name' => 'Pay By Square'
                ),
                array(
                    'method_slug' => 'google-pay',
                    'method_name' => 'Google Pay'
                ),
                array(
                    'method_slug' => 'apple-pay',
                    'method_name' => 'Apple pay'
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payment_methods');
    }
}
