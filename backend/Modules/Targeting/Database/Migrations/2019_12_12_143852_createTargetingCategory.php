<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetingCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targeting_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('targeting_id');
            $table->foreign('targeting_id')->references('id')->on('targeting');
            $table->string('category');
            $table->string('category_slug')->nullable();
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
        Schema::drop('targeting_category');
    }
}
