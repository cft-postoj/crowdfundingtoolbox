<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsFromCampaignImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_images', function (Blueprint $table) {
            $table->integer('widget_id');
            $table->integer('device_type');
            $table->foreign('widget_id')->references('id')->on('widgets');
            $table->foreign('device_type')->references('id')->on('devices_types');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_images', function (Blueprint $table) {
            //
        });
    }
}
