<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('widget_id');
            $table->integer('widget_type_id');
            $table->string('responsive_type')->nullable(); // desktop | tablet | mobile
            $table->foreign('widget_id')->references('id')->on('widgets');
            $table->foreign('widget_type_id')->references('id')->on('widget_types');
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
        Schema::dropIfExists('widget_images');
    }
}
