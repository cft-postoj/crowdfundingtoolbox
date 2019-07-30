<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankButton extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_button', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order');
            $table->string('title')->nullable();
            $table->integer('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('images');
            $table->string('redirect_link')->nullable();
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
        Schema::dropIfExists('');
    }
}
