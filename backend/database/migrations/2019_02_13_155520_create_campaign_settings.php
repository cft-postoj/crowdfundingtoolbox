<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unique();
            $table->json('promote_settings')->nullable();
            $table->json('payment_settings')->nullable();
            $table->json('widget_settings')->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaigns');
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
        Schema::dropIfExists('campaign_settings');
    }
}
