<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;

class CreateCrowdfundingSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfunding_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->unique();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('crowdfunding_settings')->insert(
            array(
                array(
                    'type' => 'general',
                    'settings' => '{}'
                ),
                array(
                    'type'  =>  'calltoaction',
                    'settings'  =>  '{}'
                ),
                array(
                    'type'  =>  'widget',
                    'settings'  =>  '{}'
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crowdfunding_settings');
    }
}
