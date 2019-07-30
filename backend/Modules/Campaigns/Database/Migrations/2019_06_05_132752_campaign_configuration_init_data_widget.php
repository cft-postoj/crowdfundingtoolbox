<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Campaigns\Entities\CampaignsConfiguration;

class CampaignConfigurationInitDataWidget extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        CampaignsConfiguration::where('id', 1)->update([
            'widget_settings' => json_encode(json_decode('{
               "headline_text":{  
                  "text":"We can write because of your financial support."
               },
               "additional_text":{  
                  "text":null
               },
               "cta":{  
                  "text":"Support us",
                  "url":"https:\/\/podpora.postoj.sk"
               },
               "backgroundColor":"#114b7d",
               "padding":{  
                  "top":"0",
                  "right":"0",
                  "bottom":"0",
                  "left":"0"
               },
               "margin":{  
                  "top":"0",
                  "right":"auto",
                  "bottom":"0",
                  "left":"auto"
               }
            }'
            ))
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
