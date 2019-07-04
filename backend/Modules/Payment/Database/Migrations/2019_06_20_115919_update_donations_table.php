<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign('donations_user_id_foreign');
            $table->dropColumn('user_id');
            $table->integer('portal_user_id')->nullable();
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->integer('widget_id')->nullable();
            $table->foreign('widget_id')->references('id')->on('widgets');
            $table->integer('referral_widget_id')->nullable();
            $table->foreign('referral_widget_id')->references('id')->on('widgets');
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
