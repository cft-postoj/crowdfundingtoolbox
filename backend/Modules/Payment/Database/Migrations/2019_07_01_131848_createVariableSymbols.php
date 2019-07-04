<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariableSymbols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_symbols', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->bigInteger('variable_symbol');
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
        Schema::drop('variable_symbols');
    }
}
