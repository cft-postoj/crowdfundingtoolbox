<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id');
            $table->integer('image_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('image_id')->references('id')->on('images');
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
        Schema::dropIfExists('campaign_images');
    }
}
