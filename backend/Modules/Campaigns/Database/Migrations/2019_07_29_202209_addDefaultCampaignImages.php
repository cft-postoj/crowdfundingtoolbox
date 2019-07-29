<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class AddDefaultCampaignImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('images')->insert(
            array(
                array(
                    'path' => 'sidebar-default.jpg',
                    'type' => 'image/jpeg',
                    'size' => '79687',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
                array(
                    'path' => 'locked-default.jpg',
                    'type' => 'image/jpeg',
                    'size' => '64507',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
                array(
                    'path' => 'leaderboard-default.jpg',
                    'type' => 'image/jpeg',
                    'size' => '166682',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
                array(
                    'path' => 'landing.jpg',
                    'type' => 'image/jpeg',
                    'size' => '169161',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
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
        //
    }
}
