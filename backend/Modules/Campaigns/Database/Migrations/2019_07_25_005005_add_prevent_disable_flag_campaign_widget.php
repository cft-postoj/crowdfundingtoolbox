<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreventDisableFlagCampaignWidget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('campaigns', function (Blueprint $table) {
            $table->boolean('prevent_disable')->nullable();
        });

        Schema::table('widgets', function (Blueprint $table) {
            $table->boolean('prevent_disable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
