<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingCampaignShow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_campaign_show', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('portal_user_id')->nullable();
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->integer('user_cookie_id')->nullable();
            $table->foreign('user_cookie_id')->references('id')->on('user_cookie');
            $table->integer('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->timestamp('valid_until');

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
        Schema::dropIfExists('');
    }
}
