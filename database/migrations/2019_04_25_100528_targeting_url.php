<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TargetingUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targeting_url', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('targeting_id');
            $table->string('path');
            $table->foreign('targeting_id')->references('id')->on('targeting');

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
        Schema::dropIfExists('targeting_url');
    }
}
