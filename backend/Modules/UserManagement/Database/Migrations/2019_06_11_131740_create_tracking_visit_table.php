<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_visit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('portal_user_id')->nullable();
            $table->foreign('portal_user_id')->references('id')->on('portal_users');
            $table->integer('user_cookie')->nullable();
            $table->string('url');
            $table->string('article_id')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_visit');
    }
}
