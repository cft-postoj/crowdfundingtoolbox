<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesDonations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->index(['portal_user_id', 'widget_id', 'referral_widget_id', 'payment_id', 'payment_method', 'tracking_show_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropIndex(['portal_user_id', 'widget_id', 'referral_widget_id', 'payment_id', 'payment_method', 'tracking_show_id']);
        });
    }
}
