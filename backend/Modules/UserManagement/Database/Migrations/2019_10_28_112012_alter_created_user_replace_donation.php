<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCreatedUserReplaceDonation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('created_users', function (Blueprint $table) {

            $table->dropColumn('donation_id');
            $table->integer('tracking_show_id')->nullable();
            $table->foreign('tracking_show_id')->references('id')->on('tracking_show');
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
