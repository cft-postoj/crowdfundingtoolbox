<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampainsUserVisting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns_visited', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->bigInteger('portal_user_id')->nullable();
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->bigInteger('user_cookie');
            $table->foreign('user_cookie')->references('id')->on('user_cookie');
            $table->integer('visits')->default(1);
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
        Schema::drop('campaigns_visited');
    }
}
