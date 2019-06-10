<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Campaigns\Entities\CampaignsConfiguration;

class CampaignConfigurationInitDataGeneral extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        CampaignsConfiguration::where('id', 1)->update([
            'fonts' => json_encode(json_decode('["Roboto Slab","Neuton","PT Sans","Roboto","Roboto Condensed","Roboto Mono","Quicksand","Indie Flower"]')),
            'colors' => json_encode(json_decode('["#9E0B0F","#114B7D","#FF7C12","#598527","#754C24","#000","#ED1C24","#0087ED","#F7AF00","#8DC63F","#fff","#555555"]')),
            'font_settings_headline_text' => json_encode(json_decode('{"fontFamily":"Roboto Slab","fontWeight":"bold","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32}')),
            'font_settings_additional_text' => json_encode(json_decode('{"fontFamily":"Neuton","fontWeight":"100","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":20}')),

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
