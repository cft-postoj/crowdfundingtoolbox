<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_read_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('article_id')->nullable();
            $table->string('url')->nullable();
            $table->string('article_title')->nullable();
            $table->string('article_category')->nullable();
            $table->integer('times_of_read');
            $table->json('read_times'); // store all current time of article read to array
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
        //
    }
}
