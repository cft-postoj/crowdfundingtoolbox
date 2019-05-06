<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomWidgetSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_widget_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('widget_id')->unique();
            $table->longText('html')->nullable();
            $table->longText('css')->nullable();
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
        Schema::dropIfExists('custom_widget_settings');
    }
}
