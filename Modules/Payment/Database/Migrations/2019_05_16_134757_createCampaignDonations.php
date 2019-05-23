<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignDonations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_donations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('campaign_id')->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->integer('widget_id')->nullable();
            $table->foreign('widget_id')->references('id')->on('widgets');
            $table->integer('referral_widget_id')->nullable();
            $table->foreign('referral_widget_id')->references('id')->on('widgets');
            $table->decimal('donation');
            $table->boolean('is_monthly_donation')->default(false);
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
        //
    }
}
