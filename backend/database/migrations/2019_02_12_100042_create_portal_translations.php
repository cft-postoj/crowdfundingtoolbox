<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortalTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portal_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->string('trans_key');
            $table->string('trans_string');
            $table->foreign('language_id')->references('id')->on('portal_languages');
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
        Schema::dropIfExists('portal_translations');
    }
}
