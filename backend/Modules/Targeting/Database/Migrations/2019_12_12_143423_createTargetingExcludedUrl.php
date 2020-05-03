<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetingExcludedUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targeting_excluded_url', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('targeting_id');
            $table->foreign('targeting_id')->references('id')->on('targeting');
            $table->string('path', 512);
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
        Schema::drop('targeting_excluded_url');
    }
}
