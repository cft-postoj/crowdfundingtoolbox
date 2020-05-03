<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTargetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('targeting', function (Blueprint $table) {
            $table->boolean('exclude_url_specific')->default(false);
            $table->boolean('exclude_homepage')->default(false);
            $table->boolean('author_specific')->default(false);
            $table->boolean('category_specific')->default(false);
            $table->boolean('show_page_view')->default(true);
            $table->boolean('show_session')->default(false);
            $table->boolean('show_nth_page_view')->default(false);
            $table->boolean('show_nth_page_view_pause')->default(false);
            $table->integer('nth_page_view_count')->default(5);
            $table->integer('nth_page_view_pause_count')->default(5);
            $table->integer('nth_page_view_pause_pause')->default(2);
            $table->boolean('popup_fixed_page_view')->default(true);
            $table->boolean('popup_fixed_once')->default(false);
            $table->boolean('popup_fixed_again_after')->default(false);
            $table->integer('popup_fixed_again_after_count')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('targeting', function(Blueprint $table) {
           $table->dropColumn(['show_page_view', 'show_session', 'show_nth_page_view', 'show_nth_page_view_pause',
               'nth_page_view', 'nth_page_view_pause_count', 'nth_page_view_pause_pause', 'popup_fixed_page_view',
               'popup_fixed_once', 'popup_fixed_again_after']);
        });
    }
}
