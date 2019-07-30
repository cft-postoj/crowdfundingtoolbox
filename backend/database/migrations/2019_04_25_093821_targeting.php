<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Targeting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targeting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id');
            $table->boolean('signed');
            $table->boolean('not_signed');
            $table->boolean('one_time');
            $table->boolean('one_time_older_than');
            $table->integer('one_time_older_than_value');
            $table->boolean('one_time_not_older_than');
            $table->integer('one_time_not_older_than_value');
            $table->boolean('monthly');
            $table->boolean('monthly_min');
            $table->integer('monthly_min_value');
            $table->boolean('monthly_max');
            $table->integer('monthly_max_value');
            $table->boolean('not_supporter');
            $table->boolean('read_articles_today');
            $table->integer('read_articles_today_min');
            $table->integer('read_articles_today_max');
            $table->boolean('read_articles_week');
            $table->integer('read_articles_week_min');
            $table->integer('read_articles_week_max');
            $table->boolean('read_articles_month');
            $table->integer('read_articles_month_min');
            $table->integer('read_articles_month_max');
            $table->boolean('registration_before');
            $table->date('registration_before_value');
            $table->boolean('registration_after');
            $table->date('registration_after_value');
            $table->boolean('url_specific');

            $table->foreign('campaign_id')->references('id')->on('campaigns');

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
        Schema::dropIfExists('targeting');
    }
}
