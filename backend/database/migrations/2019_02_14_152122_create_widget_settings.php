<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('widget_id');
            $table->json('desktop')->nullable();
            $table->json('tablet')->nullable();
            $table->json('mobile')->nullable();
            $table->foreign('widget_id')->references('id')->on('widgets');
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
        Schema::dropIfExists('widget_settings');
    }
}
