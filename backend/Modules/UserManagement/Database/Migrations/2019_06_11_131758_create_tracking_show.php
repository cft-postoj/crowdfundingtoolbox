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
            $table->integer('tracking_visit_id');
            $table->foreign('tracking_visit_id')->references('id')->on('tracking_visit');
            $table->integer('widget_id')->nullable();
            $table->foreign('widget_id')->references('id')->on('widgets');
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
