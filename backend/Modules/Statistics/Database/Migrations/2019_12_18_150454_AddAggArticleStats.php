<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAggArticleStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agg_article_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('article_id');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->string('title', 512);
            $table->string('url');
            $table->integer('visits')->default(0);
            $table->decimal('amount_sum')->default(0);
            $table->integer('new_users')->default(0);
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
        Schema::drop('agg_article_stats');
    }
}
