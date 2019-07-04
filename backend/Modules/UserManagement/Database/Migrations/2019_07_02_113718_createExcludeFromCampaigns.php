<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcludeFromCampaigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exclude_user_from_campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('portal_user_id');
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->string('reason_notes')->nullable(); // user can write reason of excluding
            /*
             * TODO: can make change if you can exclude user from specific campaigns (for example add foreign key on campaign_id)
             */
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
        Schema::drop('exclude_user_from_campaigns');
    }
}
