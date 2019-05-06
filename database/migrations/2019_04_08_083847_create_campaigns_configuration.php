<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('campaigns_configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->json('fonts')->nullable();
            $table->json('colors')->nullable();
            $table->json('font_settings_headline_text')->nullable();
            $table->json('font_settings_additional_text')->nullable();
            $table->json('cta')->nullable();
            $table->json('widget_settings')->nullable();

            $widgetTypes = DB::table('widget_types')->select('method')->get();
            foreach ($widgetTypes as $type) {
                $table->json($type->method)->nullable();
            }

            $table->timestamps();
            $table->softDeletes();
        });


        DB::table('campaigns_configuration')->insert(
            array(
                array(
                    'fonts' => json_encode(array()),
                    'colors' => json_encode(array()),
                    'font_settings_headline_text' => json_encode(array()),
                    'font_settings_additional_text' =>  json_encode(array()),
                    'cta'   =>  json_encode(array()),
                    'widget_settings'   =>  json_encode(array())
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns_configuration');
    }
}
