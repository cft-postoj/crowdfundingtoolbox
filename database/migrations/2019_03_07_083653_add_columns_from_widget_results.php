<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsFromWidgetResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('widget_results', function (Blueprint $table) {
            $table->integer('campaign_id');
            $table->integer('widget_type_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('widget_type_id')->references('id')->on('widget_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widget_results', function (Blueprint $table) {
            //
        });
    }
}
