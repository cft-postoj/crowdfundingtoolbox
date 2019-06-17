<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingShow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('basic_id');
            $table->foreign('basic_id')->references('id')->on('tracking_basic');
            $table->integer('widget_id')->nullable();
            $table->foreign('widget_id')->references('id')->on('widgets');
            $table->integer('article_id')->nullable();
            $table->string('title')->nullable();
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
        Schema::dropIfExists('');
    }
}
