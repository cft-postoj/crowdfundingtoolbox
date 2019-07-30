<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Campaigns\Entities\CampaignsConfiguration;

class CampaignConfigurationInitDataCta extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        CampaignsConfiguration::where('id', 1)->update([
            'cta' => json_encode(json_decode('{  
               "default":{  
                  "padding":{  
                     "top":"15",
                     "right":"15",
                     "bottom":"15",
                     "left":"15"
                  },
                  "margin":{  
                     "top":"10",
                     "right":"auto",
                     "bottom":"0",
                     "left":"auto"
                  },
                  "fontSettings":{  
                     "fontFamily":"Neuton",
                     "fontWeight":400,
                     "alignment":"right",
                     "color":"#FFFFFF",
                     "fontSize":24
                  },
                  "design":{  
                     "fill":{  
                        "active":true,
                        "color":"#9e0b0f",
                        "opacity":100,
                        "selected":true
                     },
                     "border":{  
                        "active":false,
                        "color":"#B71100",
                        "size":2,
                        "opacity":0,
                        "selected":true
                     },
                     "shadow":{  
                        "active":false,
                        "color":"#B71100",
                        "x":2,
                        "y":2,
                        "b":2,
                        "opacity":0,
                        "selected":true
                     },
                     "radius":{  
                        "active":false,
                        "value":"0",
                        "selected":true,
                        "tl":"10",
                        "tr":"10",
                        "br":"10",
                        "bl":"10"
                     }
                  }
               },
               "hover":{  
                  "type":"fade",
                  "fontSettings":{  
                     "fontWeight":"bold",
                     "opacity":100,
                     "color":"#FFFFFF"
                  },
                  "design":{  
                     "fill":{  
                        "active":true,
                        "color":"#B71100",
                        "opacity":100
                     },
                     "border":{  
                        "active":false,
                        "color":"#B71100",
                        "size":2,
                        "opacity":0
                     },
                     "shadow":{  
                        "active":false,
                        "color":"#B71100",
                        "x":2,
                        "y":2,
                        "b":2,
                        "opacity":0
                     },
                     "radius":{  
                        "active":false,
                        "value":"0"
                     }
                  }
               }
            }'))]);

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
