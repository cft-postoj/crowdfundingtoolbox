<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('widget_id')->unique();
            $table->longText('desktop');
            $table->longText('tablet');
            $table->longText('mobile');
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
        Schema::dropIfExists('widget_results');
    }
}
