<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoftDeleteArticleLinkWidget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('widget_results')->where('widget_type_id', 8)->delete();
        $widgets = DB::table('widgets')->where('widget_type_id', 8)->get();
        foreach ($widgets as $w) {
            DB::table('widget_settings')->where('widget_id', $w->id)->delete();
            DB::table('donations')->where('widget_id', $w->id)->delete();
            DB::table('donations')->where('referral_widget_id', $w->id)->delete();
            DB::table('tracking_show')->where('widget_id', $w->id)->delete();
            DB::table('widgets')->where('id', $w->id)->delete();
        }
        DB::table('widget_types')->where('id', 8)->delete();
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
