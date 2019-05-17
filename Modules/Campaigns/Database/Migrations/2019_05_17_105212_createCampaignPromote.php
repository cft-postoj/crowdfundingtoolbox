<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignPromote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_promotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unique();
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->date('start_date_value');
            $table->boolean('is_end_date');
            $table->date('end_date_value')->nullable();
            $table->integer('donation_goal_value')->nullable();
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
