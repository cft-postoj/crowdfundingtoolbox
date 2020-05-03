<?php

use Illuminate\Database\Seeder;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignPromote;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Targeting\Entities\Targeting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $campaign = Campaign::create([
            'name' => 'Default campaign',
            'description' => 'You have to has at least one monetization widget. To ensure this, this campaign is created and cannot be deleted or disabled.',
            'active' => true,
            'prevent_disable' => 'true'
        ]);

        $targeting = Targeting::create([
            'campaign_id' => $campaign->id,
            'signed' => true,
            'not_signed' => true,
            'one_time' => true, 'one_time_older_than' => false, 'one_time_older_than_value' => 0, 'one_time_not_older_than' => false, 'one_time_not_older_than_value' => 0, 'one_time_min' => false, 'one_time_min_value' => 0, 'one_time_max' => false, 'one_time_max_value' => 0,
            'monthly' => true, 'monthly_older_than' => false, 'monthly_older_than_value' => 0, 'monthly_not_older_than' => false, 'monthly_not_older_than_value' => 0, 'monthly_min' => false, 'monthly_min_value' => 0, 'monthly_max' => false, 'monthly_max_value' => 0,
            'not_supporter' => true,
            'read_articles_today' => false, 'read_articles_today_min' => 0, 'read_articles_today_max' => 0,
            'read_articles_week' => false, 'read_articles_week_min' => 0, 'read_articles_week_max' => 0,
            'read_articles_month' => false, 'read_articles_month_min' => 0, 'read_articles_month_max' => 0,
            'registration_before' => false, 'registration_before_value' => '2019-07-24',
            'registration_after' => false, 'registration_after_value' => '2019-07-24',
            'url_specific' => false

        ]);

        $widgetTypes = [1, 3, 4]; // landing, leaderboard, popup

        $campaignPromote = CampaignPromote::create([
            'campaign_id' => $campaign->id,
            'start_date_value' => '2000-01-01',
            'is_end_date' => true,
            'end_date_value' => '2200-01-01',
        ]);

        for ($i = 0; $i < sizeof($widgetTypes); $i++) {
            $widget = Widget::create([
                'campaign_id' => $campaign->id,
                'widget_type_id' => $widgetTypes[$i],
                'active' => true,
                'prevent_disable' => 'true'
            ]);
            $widgetSettings = WidgetSettings::create([
                'widget_id' => $widget->id,
                'desktop' => $this->getDesktopSettings($widgetTypes[$i]),
                'tablet' => $this->getTabletSettings($widgetTypes[$i]),
                'mobile' => $this->getMobileSettings($widgetTypes[$i])
            ]);
            $widgetResult = WidgetResult::create([
                'widget_id' => $widget->id,
                'campaign_id' => $campaign->id,
                'widget_type_id' => 1,
                'desktop' => $this->getDesktopResult($widgetTypes[$i]),
                'tablet' => $this->getTabletResult($widgetTypes[$i]),
                'mobile' => $this->getMobileResult($widgetTypes[$i])
            ]);
        }

        //payment settings seed
        \Illuminate\Support\Facades\Artisan::call('db:seed --class=PaymentSettingsSeeder');

    }

    private function getDesktopSettings($widgetId)
    {
        switch ($widgetId) {
            case 1:
                return '{"headline_text":null,"articleWidgetText":null,"widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32},"background":{"type":"image","image":{"path":"landing.jpg","id":4,"type":"image\\\/jpeg","updated_at":null,"created_at":null,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/landing.jpg"},"color":"#114b7d","opacity":80},"text_margin":{"top":"auto","right":"auto","bottom":"auto","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"8","right":"0","bottom":"10","left":"0"},"margin":{"top":"10","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":21},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#B71100","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"4","tr":"4","br":"4","bl":"4"}},"width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"Medium","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#B71100","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":21},"margin":{"top":"0","right":"0","bottom":"30","left":"0"},"text":"<div style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><span style=\"font-weight: bold;\">P\u00ed\u0161eme len v\u010faka va\u0161ej podpore.<\/span><\/div><div style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><span style=\"font-weight: bolder;\">\u010eakujeme.<\/span><\/div>","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"25","right":"55","bottom":"25","left":"55"},"margin":{"top":"100","right":"0","bottom":"5","left":"5"},"width":"532px","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":1,"x":3,"y":3,"b":3},"stepsPanel":true},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: &quot;Roboto Slab&quot;, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span><br>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":200},{"value":120},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">S jednorazovou podporou&nbsp;<\/span><span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj&nbsp;<\/b><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: &quot;Roboto Slab&quot;, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":120}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":120,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"<span style=\"font-family: Lato, sans-serif;\">\u00dadaje k platbe<\/span>"},"cta":{"transfer":{"text":"<span style=\"font-family: Lato, sans-serif;\">Pokra\u010dova\u0165 do banky<\/span>"},"payBySquare":{"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"<span style=\"font-family: Lato, sans-serif;\">\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu.<\/span>"},"cta":{"description":null,"text":null}},"terms":{"text":"<span style=\"font-family: Lato, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"}},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"688px","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"textContainer":{"width":"50%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"absolute","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"buttonContainer":{"width":"100%","position":"relative","top":"50px","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"35%","display":"inline-block"}}}}';
                break;
            case 3:
                return '{"headline_text":"<b>Mohli by ste n\u00e1s podpori\u0165 aj pravidelne?<\/b><br>","widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#0087ed","backgroundColor":"rgba(0,0,0,0)","fontSize":26},"background":{"type":"color","image":{"path":"leaderboard-default.jpg","type":"image\/jpeg","size":"166682","updated_at":null,"created_at":null,"id":3,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/leaderboard-default.jpg"},"color":"#ffffff","opacity":100},"text_margin":{"top":"30","right":"auto","bottom":"auto","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"12","right":"70","bottom":"15","left":"70"},"margin":{"top":"20","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":16},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"3","tr":"3","bl":"3","br":"3"}},"display":"relative","width":"345px"},"hover":{"type":"fade","fontSettings":{"fontWeight":"bold","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":"<b>8 z 10 na\u0161ich podporovate\u013eov n\u00e1s podporuje pravidelne.<\/b> V\u010faka pravide\u013en\u00fdm platb\u00e1m m\u00f4\u017eeme lep\u0161ie pl\u00e1nova\u0165 pr\u00e1cu na\u0161ej redakcie a s v\u00e4\u010d\u0161\u00edm pokojom tvor\u00edme Postoj.&nbsp;","fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#000000","backgroundColor":"rgba(0,0,0,0)","fontSize":16},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"15","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":0},"margin":{"top":"10","right":"0","bottom":"10","left":"0"},"text":"<br>","textColor":"#0087ed","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"5","right":"5","bottom":"5","left":"5"},"margin":{"top":"0","right":"0","bottom":"5","left":"5"},"width":"100%","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":0,"x":3,"y":3,"b":3},"shadowBox":false,"stepsPanel":false},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":6,"options":[{"value":5},{"value":10},{"value":15},{"value":20},{"value":30}],"benefit":{"active":true,"text":"S podporou <b>10\u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/b>&nbsp;<div>a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/div>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":6,"options":[{"value":20},{"value":30},{"value":60},{"value":120},{"value":200}],"benefit":{"active":true,"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-weight: bolder; font-family: Roboto Slab, sans-serif;\">120\u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj<\/span><span style=\"font-family: Roboto Slab, sans-serif;\">&nbsp;<\/span><div style=\"font-family: Roboto Slab, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/div>","value":120}},"default_price":{"monthly_active":true,"monthly_value":10,"one_time_active":true,"one_time_value":120,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">\u00dadaje k platbe<\/span>"},"cta":{"transfer":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 do banky<\/span>"},"payBySquare":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu.<\/span>"},"cta":{"description":null,"text":null}},"terms":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"},"currency":"\u20ac","currencyInPriceOptions":"sum"},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"auto","maxWidth":"100%","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"15","bottom":"15","left":"15"},"bodyContainer":{"width":"100%","height":"100%","margin":{"top":"0","right":"auto","bottom":0,"left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"300px","maxWidth":"100%"}},"textContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","top":"20px","textAlign":"center"}},"buttonContainer":{"width":"100%","position":"relative","top":"60","right":"auto","bottom":"0","left":"auto","textAlign":"center","button":{"width":"100%","alignment":"center","fontSize":26,"padding":{"top":"20","right":"70","bottom":"25","left":"70"}}}}}';
                break;
            case 4:
                return '{"headline_text":"<br>","widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#114b7d","backgroundColor":"rgba(0,0,0,0)","fontSize":25},"background":{"type":"color","image":{"path":"leaderboard-default.jpg","type":"image\/jpeg","size":"166682","updated_at":null,"created_at":null,"id":3,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/leaderboard-default.jpg"},"color":"#ffffff","opacity":100},"text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"10","right":"30","bottom":"15","left":"30"},"margin":{"top":"8","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":16},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"5","tr":"5","bl":"5","br":"5"}},"display":"relative","width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"bold","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":25},"margin":{"top":"15","right":"0","bottom":"30","left":"0"},"text":"<div style=\"font-family: Roboto Slab, sans-serif;\"><span style=\"font-weight: bold;\">P\u00ed\u0161eme len v\u010faka va\u0161ej podpore.<\/span><\/div><div style=\"font-family: Roboto Slab, sans-serif;\"><span style=\"font-weight: bolder;\">\u010eakujeme.<\/span><\/div>","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"5","right":"5","bottom":"5","left":"5"},"margin":{"top":"0","right":"0","bottom":"5","left":"5"},"width":"100%","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":0,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: Roboto Slab, sans-serif;\"><b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-family: Roboto Slab, sans-serif; background-color: transparent; font-size: 1rem;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S jednorazovou podporou&nbsp;<\/span><span style=\"font-family: Roboto Slab, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj&nbsp;<\/b><\/span><span style=\"font-family: Roboto Slab, sans-serif; background-color: transparent; font-size: 1rem;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":120}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":100,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"\u00dadaje k platbe"},"cta":{"transfer":{"text":"Pokra\u010dova\u0165 do banky"},"payBySquare":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu."},"cta":{"description":null,"text":null}},"terms":{"text":"S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov."},"currencyInPriceOptions":"sum","currency":"\u20ac"},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"532px","height":"auto","maxWidth":"100%","position":"fixed","fixedSettings":{"top":"15%","bottom":"auto","zIndex":999999,"textAlign":"center"},"display":"block","padding":{"top":"0","right":"30","bottom":"0","left":"30"},"bodyContainer":{"width":"100%","height":"100%","margin":{"top":"0","right":"auto","bottom":0,"left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","maxWidth":"100%"}},"textContainer":{"width":"100","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"50","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","top":"10px","textAlign":"center","fontSize":35}},"buttonContainer":{"width":"100","position":"relative","top":"80","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"300px","maxWidth":"100%","alignment":"center","fontSize":35,"padding":{"top":"15","right":"45","bottom":"15","left":"45"}}}}}';
                break;
        }
    }

    private function getTabletSettings($widgetId)
    {
        switch ($widgetId) {
            case 1:
                return '{"headline_text":null,"articleWidgetText":null,"widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32},"background":{"type":"image","image":{"path":"landing.jpg","id":4,"type":"image\\\/jpeg","updated_at":null,"created_at":null,"url":"http:\/\/127.0.0.1:8001\/backend\/public\/images\/widgets\/landing.jpg"},"color":"#114b7d","opacity":100},"text_margin":{"top":"auto","right":"auto","bottom":"auto","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"8","right":"0","bottom":"10","left":"0"},"margin":{"top":"10","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":21},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#B71100","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"4","tr":"4","br":"4","bl":"4"}},"width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"Medium","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#B71100","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":21},"margin":{"top":"0","right":"0","bottom":"30","left":"0"},"text":"<div style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><span style=\"font-weight: bold;\">P\u00ed\u0161eme len v\u010faka va\u0161ej podpore.<\/span><\/div><div style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><span style=\"font-weight: bolder;\">\u010eakujeme.<\/span><\/div>","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"25","right":"55","bottom":"25","left":"55"},"margin":{"top":"100","right":"0","bottom":"5","left":"5"},"width":"532px","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":1,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: &quot;Roboto Slab&quot;, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span><br>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":200},{"value":120},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">S jednorazovou podporou&nbsp;<\/span><span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: &quot;Roboto Slab&quot;, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":120}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":120,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"title"},"cta":{"transfer":{"text":"Go to your bank"},"payBySquare":{"text":"Go to your bank"}}},"third_step":{"title":{"text":"Thank you for your support"},"cta":{"description":"To get all rewards please  fill your personal data in My profile","text":"My profile"}},"terms":{"text":"<span style=\"font-family: Lato, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"}},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"100vh","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"textContainer":{"width":"50%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"absolute","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"buttonContainer":{"width":"100%","position":"relative","top":"50px","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"35%","display":"inline-block"}}}}';
                break;
            case 3:
                return '{"headline_text":"<b>Mohli by ste n\u00e1s podpori\u0165 aj pravidelne?<\/b>","widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#0087ed","backgroundColor":"rgba(0,0,0,0)","fontSize":24},"background":{"type":"color","image":{"path":"leaderboard-default.jpg","type":"image\/jpeg","size":"166682","updated_at":null,"created_at":null,"id":3,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/leaderboard-default.jpg"},"color":"#ffffff","opacity":100},"text_margin":{"top":"15","right":"auto","bottom":"auto","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"10","right":"70","bottom":"10","left":"70"},"margin":{"top":"20","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":16},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"5","tr":"5","bl":"5","br":"5"}},"display":"relative"},"hover":{"type":"fade","fontSettings":{"fontWeight":"bold","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":"<b>8 z 10 na\u0161ich podporovate\u013eov n\u00e1s podporuje pravidelne. <\/b>V\u010faka pravide\u013en\u00fdm platb\u00e1m m\u00f4\u017eeme lep\u0161ie pl\u00e1nova\u0165 pr\u00e1cu na\u0161ej redakcie a s v\u00e4\u010d\u0161\u00edm pokojom tvor\u00edme Postoj.&nbsp;","fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#000000","backgroundColor":"rgba(0,0,0,0)","fontSize":16},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"10","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":0},"margin":{"top":"10","right":"0","bottom":"10","left":"0"},"text":null,"textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"5","right":"5","bottom":"5","left":"5"},"margin":{"top":"15","right":"0","bottom":"5","left":"5"},"width":"100%","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":0,"x":3,"y":3,"b":3},"shadowBox":false,"stepsPanel":false},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":6,"options":[{"value":5},{"value":10},{"value":15},{"value":20},{"value":30}],"benefit":{"active":true,"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S podporou&nbsp;<\/span><b><span style=\"font-family: Roboto Slab, sans-serif;\">10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/span><span style=\"font-family: Roboto Slab, sans-serif;\">&nbsp;<\/span><\/b><div style=\"font-family: Roboto Slab, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/div>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":6,"options":[{"value":20},{"value":30},{"value":60},{"value":120},{"value":200}],"benefit":{"active":true,"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S podporou&nbsp;<\/span><b><span style=\"font-family: Roboto Slab, sans-serif;\">120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj<\/span><span style=\"font-family: Roboto Slab, sans-serif;\">&nbsp;<\/span><\/b><div style=\"font-family: Roboto Slab, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/div>","value":120}},"default_price":{"monthly_active":true,"monthly_value":10,"one_time_active":true,"one_time_value":120,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">\u00dadaje k platbe<\/span>"},"cta":{"transfer":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 do banky<\/span>"},"payBySquare":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu.<\/span>"},"cta":{"description":null,"text":null}},"terms":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"},"currency":"\u20ac","currencyInPriceOptions":"sum"},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"auto","maxWidth":"100%","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"15","bottom":"0","left":"15"},"bodyContainer":{"width":"100%","height":"100%","margin":{"top":"0","right":"auto","bottom":0,"left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"300px","maxWidth":"100%"}},"textContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","top":"30px","textAlign":"center"}},"buttonContainer":{"width":"100%","position":"relative","top":"40","right":"auto","bottom":"0","left":"auto","textAlign":"center","button":{"width":"100%","alignment":"center","padding":{"top":"15","right":"70","bottom":"20","left":"70"}}}}}';
                break;
            case 4:
                return '{"headline_text":"<br>","widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#114b7d","backgroundColor":"rgba(0,0,0,0)","fontSize":20},"background":{"type":"color","image":{"path":"leaderboard-default.jpg","type":"image\/jpeg","size":"166682","updated_at":null,"created_at":null,"id":3,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/leaderboard-default.jpg"},"color":"#ffffff","opacity":100},"text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"10","right":"30","bottom":"15","left":"30"},"margin":{"top":"8","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#ffffff","fontSize":16},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"5","tr":"5","bl":"5","br":"5"}},"display":"relative","width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"bold","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#B71100","opacity":100},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":25},"margin":{"top":"15","right":"0","bottom":"30","left":"0"},"text":"<span style=\"font-weight: bold;\">P\u00ed\u0161eme len v\u010faka va\u0161ej podpore.<\/span><span style=\"font-weight: bolder;\">\u010eakujeme.<\/span>","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"5","right":"5","bottom":"5","left":"5"},"margin":{"top":"0","right":"0","bottom":"5","left":"5"},"width":"100%","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":0,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"S podporou <b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj&nbsp;<\/b><span style=\"font-size: 1rem; background-color: transparent; font-family: Roboto Slab, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span><br>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S jednorazovou podporou&nbsp;<\/span><span style=\"font-family: Roboto Slab, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: Roboto Slab, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":120}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":100,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">\u00dadaje k platbe<\/span>"},"cta":{"transfer":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 do banky<\/span>"},"payBySquare":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu.<\/span>"},"cta":{"description":null,"text":null}},"terms":{"text":"<span style=\"font-family: Roboto Slab, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"},"currency":"\u20ac","currencyInPriceOptions":"sum"},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"500px","height":"auto","maxWidth":"100%","position":"fixed","fixedSettings":{"top":"5%","bottom":"auto","zIndex":999999,"textAlign":"center"},"display":"block","padding":{"top":"0","right":"30","bottom":"0","left":"30"},"bodyContainer":{"width":"100%","height":"100%","margin":{"top":"0","right":"auto","bottom":0,"left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","maxWidth":"100%"}},"textContainer":{"width":"100","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"8","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","top":"10px","textAlign":"center"}},"buttonContainer":{"width":"100","position":"relative","top":"30","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"300px","maxWidth":"100%","alignment":"center","padding":{"top":"12","right":"30","bottom":"15","left":"30"}}}}}';
                break;
        }
    }

    private function getMobileSettings($widgetId)
    {
        switch ($widgetId) {
            case 1:
                return '{"headline_text":null,"articleWidgetText":null,"widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32},"background":{"type":"image","image":{"path":"landing.jpg","id":4,"type":"image\\\/jpeg","updated_at":null,"created_at":null,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/landing.jpg"},"color":"#114b7d","opacity":100},"text_margin":{"top":"auto","right":"auto","bottom":"auto","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"8","right":"0","bottom":"10","left":"0"},"margin":{"top":"10","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":21},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#B71100","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"4","tr":"4","br":"4","bl":"4"}},"width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"Medium","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#B71100","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":16},"margin":{"top":"0","right":"0","bottom":"30","left":"0"},"text":"<div style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><span style=\"font-weight: bold;\">P\u00ed\u0161eme len v\u010faka va\u0161ej podpore.<\/span><\/div><div style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><span style=\"font-weight: bolder;\">\u010eakujeme.<\/span><\/div>","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"24","right":"24","bottom":"24","left":"24"},"margin":{"top":"40","right":"0","bottom":"5","left":"5"},"width":"auto","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":1,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":2,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: &quot;Roboto Slab&quot;, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span><br>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":2,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"<span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\">S jednorazovou podporou<b>&nbsp;<\/b><\/span><span style=\"font-family: &quot;Roboto Slab&quot;, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: &quot;Roboto Slab&quot;, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":120}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":120,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"title"},"cta":{"transfer":{"text":"Go to your bank"},"payBySquare":{"text":"Go to your bank"}}},"third_step":{"title":{"text":"Thank you for your support"},"cta":{"description":"To get all rewards please  fill your personal data in My profile","text":"My profile"}},"terms":{"text":"<span style=\"font-family: Lato, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"}},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"688px","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"textContainer":{"width":"50%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"absolute","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"buttonContainer":{"width":"100%","position":"relative","top":"50px","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"35%","display":"inline-block"}}}}';
                break;
            case 3:
                return '{"headline_text":"<span style=\"font-family: Lato, sans-serif;\"><b>Mohli by ste n\u00e1s podpori\u0165 aj pravidelne?<\/b><\/span>","widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#0087ed","backgroundColor":"rgba(0,0,0,0)","fontSize":20},"background":{"type":"color","image":{"path":"leaderboard-default.jpg","type":"image\/jpeg","size":"166682","updated_at":null,"created_at":null,"id":3,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/leaderboard-default.jpg"},"color":"#ffffff","opacity":100},"text_margin":{"top":"0","right":"auto","bottom":"auto","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"7","right":"70","bottom":"10","left":"70"},"margin":{"top":"20","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":16},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"5","tr":"5","bl":"5","br":"5"}},"display":"relative"},"hover":{"type":"fade","fontSettings":{"fontWeight":"bold","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":"<span style=\"font-family: Lato, sans-serif;\"><b>8 z 10 na\u0161ich podporovate\u013eov n\u00e1s podporuje pravidelne.<\/b><\/span><span style=\"font-family: Lato, sans-serif;\"><b>&nbsp;<\/b>V\u010faka pravide\u013en\u00fdm platb\u00e1m m\u00f4\u017eeme lep\u0161ie pl\u00e1nova\u0165 pr\u00e1cu na\u0161ej redakcie a s v\u00e4\u010d\u0161\u00edm pokojom tvor\u00edme Postoj.&nbsp;<\/span>","fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#000000","backgroundColor":"rgba(0,0,0,0)","fontSize":13},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"10","right":"auto","bottom":"10","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":0},"margin":{"top":"10","right":"0","bottom":"10","left":"0"},"text":null,"textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"5","right":"5","bottom":"5","left":"5"},"margin":{"top":"0","right":"0","bottom":"5","left":"5"},"width":"100%","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":0,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":5},{"value":10},{"value":15},{"value":20},{"value":30}],"benefit":{"active":true,"text":"<span style=\"font-family: Lato, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: Lato, sans-serif;\"><b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj&nbsp;<\/b><\/span><div><span style=\"font-family: Lato, sans-serif; background-color: transparent; font-size: 1rem;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span><\/div>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":20},{"value":30},{"value":60},{"value":100},{"value":200}],"benefit":{"active":true,"text":"<span style=\"font-family: Lato, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: Lato, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj&nbsp;<\/b><\/span><div style=\"font-family: Lato, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/div>","value":120}},"default_price":{"monthly_active":true,"monthly_value":10,"one_time_active":true,"one_time_value":120,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"<span style=\"font-family: Lato, sans-serif;\">\u00dadaje k platbe<\/span>"},"cta":{"transfer":{"text":"<span style=\"font-family: Lato, sans-serif;\">Pokra\u010dova\u0165 do banky<\/span>"},"payBySquare":{"text":"<span style=\"font-family: Lato, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"<span style=\"font-family: Lato, sans-serif;\">\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu.<\/span>"},"cta":{"description":null,"text":"My profile"}},"terms":{"text":"<span style=\"font-family: Lato, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"},"currency":"\u20ac","currencyInPriceOptions":"period"},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"auto","maxWidth":"100%","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"15","right":"15","bottom":"15","left":"15"},"bodyContainer":{"width":"100%","height":"100%","margin":{"top":"0","right":"auto","bottom":0,"left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"300px","maxWidth":"100%"}},"textContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","top":"0px","textAlign":"center"}},"buttonContainer":{"width":"100%","position":"relative","top":"50","right":"auto","bottom":"0","left":"auto","textAlign":"center","button":{"width":"100%","alignment":"center","padding":{"top":"15","right":"50","bottom":"20","left":"50"}}}}}';
                break;
            case 4:
                return '{"headline_text":"<br>","widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#114b7d","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"background":{"type":"color","image":{"path":"leaderboard-default.jpg","type":"image\/jpeg","size":"166682","updated_at":null,"created_at":null,"id":3,"url":"http:\/\/127.0.0.1:8001\/public\/images\/widgets\/leaderboard-default.jpg"},"color":"#ffffff","opacity":100},"text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"text_display":null,"text_background":null,"common_text":[]},"call_to_action":{"default":{"padding":{"top":"10","right":"30","bottom":"15","left":"30"},"margin":{"top":"8","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","fontSize":16},"design":{"fill":{"active":true,"color":"#0087ed","opacity":100,"selected":true},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":true,"value":"0","selected":true,"tl":"5","tr":"5","bl":"5","br":"5"}},"display":"relative","width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"bold","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#114b7d","opacity":100},"border":{"active":false,"color":"#FFFFFF","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":18},"margin":{"top":"15","right":"0","bottom":"15","left":"0"},"text":"<div style=\"font-family: Lato, sans-serif;\"><span style=\"font-weight: bold;\">P\u00ed\u0161eme len v\u010faka va\u0161ej podpore.<\/span><\/div><div style=\"font-family: Lato, sans-serif;\"><span style=\"font-weight: bolder;\">\u010eakujeme.<\/span><\/div>","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"5","right":"15","bottom":"5","left":"15"},"margin":{"top":"0","right":"0","bottom":"5","left":"5"},"width":"100%","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":0,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":2,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"<span style=\"font-family: Lato, sans-serif;\">S podporou&nbsp;<\/span><span style=\"font-family: Lato, sans-serif;\"><b>10 \u20ac a viac mesa\u010dne sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: Lato, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span><br>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":2,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"<span style=\"font-family: Lato, sans-serif;\">S jednorazovou podporou&nbsp;<\/span><span style=\"font-family: Lato, sans-serif;\"><b>120 \u20ac a viac sa st\u00e1vate \u010dlenom Klubu Postoj<\/b><span style=\"font-weight: bolder;\">&nbsp;<\/span><\/span><span style=\"font-size: 1rem; background-color: transparent; font-family: Lato, sans-serif;\">a z\u00edskavate na\u0161e \u0161peci\u00e1lne tla\u010den\u00e9 vydanie.<\/span>","value":120}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":100,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"<span style=\"font-family: Lato, sans-serif;\">\u00dadaje k platbe<\/span>"},"cta":{"transfer":{"text":"<span style=\"font-family: Lato, sans-serif;\">Pokra\u010dova\u0165 do banky<\/span>"},"payBySquare":{"text":"<span style=\"font-family: Lato, sans-serif;\">Pokra\u010dova\u0165 k platbe<\/span>"}}},"third_step":{"title":{"text":"<span style=\"font-family: Lato, sans-serif;\">\u010eakujeme. V\u00e1\u017eime si va\u0161u podporu.<\/span>"},"cta":{"description":null,"text":null}},"terms":{"text":"<span style=\"font-family: Lato, sans-serif;\">S\u00fahlas\u00edm so spracovan\u00edm osobn\u00fdch \u00fadajov.<\/span>"},"currency":"\u20ac","currencyInPriceOptions":"sum"},"email_settings":{"active":false,"subscribe_text":null},"cta":{"text":"Podpori\u0165 denn\u00edk","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"100vh","maxWidth":"100%","position":"fixed","fixedSettings":{"top":"0","bottom":"auto","zIndex":999999,"textAlign":"center"},"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","height":"100%","margin":{"top":"0","right":"auto","bottom":0,"left":"auto"},"position":"relative","top":"auto","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","maxWidth":"100%"}},"textContainer":{"width":"100","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"8","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%","top":"10px","textAlign":"center"}},"buttonContainer":{"width":"100","position":"relative","top":"30","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"300px","maxWidth":"100%","alignment":"center","padding":{"top":"12","right":"30","bottom":"15","left":"30"}}}}}';
                break;
        }

    }

    private function getDesktopResult($widgetId)
    {

        switch ($widgetId) {
            case 1:
                return '<link _ngcontent-c31="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c31="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: calc(100% + 140px); top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c31="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-landing" style="position: relative; height: 688px; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px; background-position: center center; background-image: url(https://postoj.sk/uploads/13462/conversions/cover.jpg);"><div _ngcontent-c31="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(17, 75, 125); opacity: 0;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c31="" ng-reflect-ng-class="[object Object]" class="container"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c31="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(255, 255, 255); height: auto; overflow: hidden;"><div _ngcontent-c31="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c31="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 32px; color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: auto; background-color: rgba(0, 0, 0, 0);"></div><div _ngcontent-c31="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><!----><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c31="" class="preview-monetization" _nghost-c43="" ng-reflect-widget="[object Object]" ng-reflect-device-type="desktop"><link _ngcontent-c43="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 532px; height: auto; background-color: rgb(255, 255, 255); margin: 100px 0px 5px 5px;"><div _ngcontent-c43="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: block;"><span _ngcontent-c43="" class="step-back cft--monatization--hidden" onclick="parent.stepClassic(this, false)"></span><span _ngcontent-c43="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c43="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 25px 55px;"><div _ngcontent-c43="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<div style=\"font-family: &quot"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><div><span>Píšeme len vďaka vašej podpore.</span></div><div><span>Ďakujeme.</span></div></h2></div><div _ngcontent-c43="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="30"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="20"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="15"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="10"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="5"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly custom" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this, true)" oninput="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="iná suma" style="font-size: 16px; font-weight: 400; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: white; width: 100%; height: 100%; color: rgb(31, 78, 123);"></div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="200"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="120"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 120  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="60"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="30"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="20"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time custom" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this, true)" oninput="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="iná suma" style="font-size: 16px; font-weight: 400; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: white; width: 100%; height: 100%; color: rgb(31, 78, 123);"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c43="" class="cft--monatization--membership-checkbox cft--monatization--membership-checkbox--monthly active" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c43="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; width: 100%; max-width: 100%; min-height: 34px;"><span>S podporou&nbsp;</span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span><br></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c43="" class="cft--monatization--membership-checkbox cft--monatization--membership-checkbox--one-time active" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c43="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; width: 100%; max-width: 100%; min-height: 34px;"><span>S jednorazovou podporou&nbsp;</span><span><b>120 € a viac sa stávate členom Klubu Postoj&nbsp;</b></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><form _ngcontent-c43="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmitClassic(this, event)"><div _ngcontent-c43="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px; font-size: 16px;"><label _ngcontent-c43="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c43="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChangeClassic(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: rgb(85, 85, 85); padding: 6px; width: 100%; font-size: 16px; height: 45px;"><label _ngcontent-c43="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Zadaný email je v nesprávnom tvare.</label></div><div _ngcontent-c43="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px; font-size: 16px;"><input _ngcontent-c43="" name="terms_agreed" required="" type="checkbox" value="0" id="cft--monatization--form--donate--terms--1--"><label _ngcontent-c43="" style="display: inline; padding-left: 6px;" for="cft--monatization--form--donate--terms--1--"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c43="" class="error" ng-reflect-ng-style="[object Object]" id="cft--monatization--form--donate--terms-error--1--" for="cft--monatization--form--donate--terms--1--" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><button _ngcontent-c43="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c43="" href="javascript:void(0)" onclick="parent.oneTimePaymentClassic(this)" ng-reflect-ng-style="[object Object]" style="text-decoration: underline; color: rgb(35, 147, 232); font-size: 16px;">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c43="" href="javascript:void(0)" onclick="parent.monthlyPaymentClassic(this)" ng-reflect-ng-style="[object Object]" style="text-decoration: underline; color: rgb(35, 147, 232); font-size: 16px;">Pravidelná podpora</a></div></div><div _ngcontent-c43="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><span>Údaje k platbe</span></h2></div><input _ngcontent-c43="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c43="" class="cft--monetization--nationalPayment"><div _ngcontent-c43="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c43="" onclick="parent.paymentCountryTypeClassic(this, \'home\')">Domáca platba <input _ngcontent-c43="" checked="" type="radio" name="nationalPayment--1--null" id="home--1--null"><span _ngcontent-c43="" class="checkmark"></span></label></div><div _ngcontent-c43="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c43="" onclick="parent.paymentCountryTypeClassic(this, \'foreign\')">Zahraničná platba <input _ngcontent-c43="" type="radio" name="nationalPayment--1--null" id="abroad--1--null"><span _ngcontent-c43="" class="checkmark"></span></label></div></div><div _ngcontent-c43="" class="payment-options"><label _ngcontent-c43="" class="payment-options__button" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-transfer--1--null"><input _ngcontent-c43="" checked="checked" type="radio" value="1" name="payment-option--1--null" class="cr0wdWidgetContent-landing-transfer" id="cr0wdWidgetContent-landing-transfer--1--null"><div _ngcontent-c43="">Platba na účet</div></label><label _ngcontent-c43="" class="payment-options__button" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-cardPay--1--null"><input _ngcontent-c43="" type="radio" value="2" name="payment-option--1--null" class="cr0wdWidgetContent-landing-cardPay" id="cr0wdWidgetContent-landing-cardPay--1--null"><div _ngcontent-c43="">Platobná karta</div><div _ngcontent-c43="" class="cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="font-size: 12px; color: rgb(85, 85, 85);">(automatické obnovovanie)</div></label><label _ngcontent-c43="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-payBySquare--1--null"><input _ngcontent-c43="" type="radio" value="3" name="payment-option--1--null" class="cr0wdWidgetContent-landing-payBySquare" id="cr0wdWidgetContent-landing-payBySquare--1--null"><div _ngcontent-c43="">Pay by square</div></label></div><div _ngcontent-c43="" class="payment-option" data-id="1"><div _ngcontent-c43="" class="cft--monetization--bankTransfer"><table _ngcontent-c43="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c43=""><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">IBAN</td><td _ngcontent-c43="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Var. symbol</td><td _ngcontent-c43="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Suma</td><td _ngcontent-c43="" class="payment-value"><span _ngcontent-c43="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c43="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c43="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c43="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c43="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c43="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c43="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať do banky</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c43="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok  <span _ngcontent-c43="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c43="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c43="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c43="" style="text-align:center;margin: 30px auto"><img _ngcontent-c43="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><div _ngcontent-c43="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c43="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><span>Ďakujeme. Vážime si vašu podporu.</span></h1></div><h4 _ngcontent-c43="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c43="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c43=""><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">IBAN</td><td _ngcontent-c43="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Var. symbol</td><td _ngcontent-c43="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Suma</td><td _ngcontent-c43="" class="payment-value"><span _ngcontent-c43="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c43="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!----><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c31="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 15px; top: 15px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c31="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c31="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c31="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c31="" id="icon" transform="translate(5 5)"><path _ngcontent-c31="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(255, 255, 255);"></path></g></g></svg></span></div><div _ngcontent-c31="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c31="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }

            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }

            [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button:after {
                    content: \'€\';
                    position: absolute;
                    top: 23px;
                    right: 25px;
                    font-size: 16px;
                    font-family: Arial,Verdana,sans-serif;
                    color: #1f4e7b;
            }
           [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button input:focus::placeholder {
                    color:transparent;
           }

            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; }
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--container a {
    text-decoration: underline !important;
    }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:Medium!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c31="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthlyClassic(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var header = chosenButton.closest(\'.cft--monetization--container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = header.getElementsByClassName(\'cft--monatization--membership-checkbox--monthly\')[0];
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValueClassic(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTimeClassic(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var header = chosenButton.closest(\'.cft--monetization--container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = header.getElementsByClassName(\'cft--monatization--membership-checkbox--one-time\')[0];
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValueClassic(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateFormClassic(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity()
        && monetizationCont.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checkValidity();
    return validInput;
}
function oneTimePaymentClassic(el) {
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var choosedPaymentTypes = monetizationEl.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = monetizationEl.querySelector(\'#cft--monatization--donation--one-time\');
    var monthlyButton = monetizationEl.querySelector(\'#cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    monetizationEl.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    monetizationEl.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    monetizationEl.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    monetizationEl.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPaymentClassic(el) {
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var choosedPaymentTypes = monetizationEl.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = monetizationEl.querySelector(\'#cft--monatization--donation--one-time\');
    var monthlyButton = monetizationEl.querySelector(\'#cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
}
function trackInsertValueClassic(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChangeClassic(el) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmitClassic(el, event) {
    event.preventDefault();
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateFormClassic(el)) {
        monetizationEl.querySelector(\'.cft--monetization--container-step-1 button[type="submit"]\').classList.add(\'cft--monatization--hidden\');
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').value,
            \'email_valid\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity(),
            \'terms\': el.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStepClassic(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').value,
            \'email_valid\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity(),
            \'terms\': el.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStepClassic(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtonsClassic(monetizationEl, bankButtons);
    stepClassic(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButtonClassic(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtonsClassic(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButtonClassic(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButtonClassic(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButtonClassic(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgressClassic(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'input[name*=payment-option]:checked\').value
    });
    var selectedId = monetizationCont.querySelector(\'input[name*=payment-option]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            stepClassic(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptionsClassic(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name*="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function stepClassic(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
        monetizationCont.querySelector(\'.cft__cta__button\').classList.remove(\'cft--monatization--hidden\');
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryTypeClassic(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    // const cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\') as any;
    // const bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\') as any;
    var cardPayOptions = monetizationCont.querySelectorAll(\'input[name="payment-option"][value="2"]\');
    var bankTransferOptions = monetizationCont.querySelectorAll(\'input[name="payment-option"][value="1"]\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptionsClassic(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
        monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
        console.log(\'VALUEE \' + monetizationCont.querySelector(\'.payment-options__button input:checked\').value);
        if (monetizationCont.querySelector(\'.payment-options__button input:checked\').value === \'2\') {
            monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
        }
        else {
            monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.add(\'cft--monatization--hidden\');
        }
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
            case 3:
                return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-leaderboard" style="position: relative; height: auto; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px 15px 15px;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(255, 255, 255); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c14="" ng-reflect-ng-class="[object Object]"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(0, 135, 237); height: auto; overflow: hidden;"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 26px; color: rgb(0, 135, 237); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: 30px auto auto; background-color: rgba(0, 0, 0, 0);"><span><b>Mohli by ste nás podporiť aj pravidelne?</b></span><br></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 16px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 15px auto 0px; color: rgb(0, 0, 0);"><b>8 z 10 našich podporovateľov nás podporuje pravidelne.</b> Vďaka pravideľným platbám môžeme lepšie plánovať prácu našej redakcie a s väčším pokojom tvoríme Postoj.&nbsp;</div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="desktop"><link _ngcontent-c27="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 0px 0px 5px 5px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<br>"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(0, 135, 237); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(0, 135, 237); text-align: center;"><br></h2></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="120"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 120 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 € </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 700px;">S podporou <b>10€ a viac mesačne sa stávate členom Klubu Postoj</b>&nbsp;<div>a získavate naše špeciálne tlačené vydanie.</div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 700px;"><span>S podporou&nbsp;</span><span>120€ a viac sa stávate členom Klubu Postoj</span><span>&nbsp;</span><div>a získavate naše špeciálne tlačené vydanie.</div></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 345px; padding: 12px 70px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 3px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Pravidelná podpora</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(0, 135, 237); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(0, 135, 237); text-align: center;"><span>Údaje k platbe</span></h2></div><input _ngcontent-c27="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c27="" class="cft--monetization--nationalPayment"><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'home\')">Domáca platba <input _ngcontent-c27="" checked="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'foreign\')">Zahraničná platba <input _ngcontent-c27="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div></div><div _ngcontent-c27="" class="payment-options"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" class="cr0wdWidgetContent-leaderboard-transfer" id="cr0wdWidgetContent-leaderboard-transfer"><div _ngcontent-c27="">Platba na účet</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-cardPay"><input _ngcontent-c27="" name="payment-option" type="radio" value="2" class="cr0wdWidgetContent-leaderboard-cardPay" id="cr0wdWidgetContent-leaderboard-cardPay"><div _ngcontent-c27="">Platobná karta</div></label><label _ngcontent-c27="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-payBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" class="cr0wdWidgetContent-leaderboard-payBySquare" id="cr0wdWidgetContent-leaderboard-payBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><div _ngcontent-c27="" class="cft--monetization--bankTransfer"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c27="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c27="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c27="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 345px; padding: 12px 70px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 3px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať do banky</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 345px; padding: 12px 70px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 3px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c27="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok po  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c27="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c27="" style="text-align:center;margin: 30px auto"><img _ngcontent-c27="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 345px; padding: 12px 70px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 3px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(0, 135, 237); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(0, 135, 237); text-align: center;"><span>Ďakujeme. Vážime si vašu podporu.</span></h1></div><h4 _ngcontent-c27="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 345px; padding: 12px 70px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 3px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 15px; top: 15px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(0, 135, 237);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }
        
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; } 
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:bold!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var landingDocument = document;
    // to work inside iframe
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTime(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--one-time\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateForm(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'#cft--monatization--form--donate--email\').checkValidity()
        && monetizationCont.querySelector(\'#cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
    // show comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    // hide cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
    // comfortpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
}
function trackInsertValue(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChange(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmit(el, event) {
    event.preventDefault();
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateForm(el)) {
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButton(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButton(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgress(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'.payment-option\').dataset.id
    });
    var selectedId = monetizationCont.querySelector(\'input[name="payment-option"]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptions(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function step(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryType(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    var cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\');
    var bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptions(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
            case 4:
                return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: block; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-popup" style="position: fixed; height: auto; width: 532px; max-width: 100%; top: 15%; bottom: auto; left: calc(50% - 266px); margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px 30px; z-index: 99999;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(255, 255, 255); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c14="" ng-reflect-ng-class="[object Object]"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(17, 75, 125); height: auto; overflow: hidden;"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 35px; color: rgb(17, 75, 125); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: 0px auto; background-color: rgba(0, 0, 0, 0);"><br></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="desktop"><link _ngcontent-c27="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 0px 0px 5px 5px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<div style=\"font-family: Lato,"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><div><span>Píšeme len vďaka vašej podpore.</span></div><div><span>Ďakujeme.</span></div></h2></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 100%;"><span>S podporou&nbsp;</span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 100%;"><span>S jednorazovou podporou&nbsp;</span><span><b>120 € a viac sa stávate členom Klubu Postoj&nbsp;</b></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;">Súhlasím so spracovaním osobných údajov.</label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Pravidelná podpora</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;">Údaje k platbe</h2></div><input _ngcontent-c27="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c27="" class="cft--monetization--nationalPayment"><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'home\')">Domáca platba <input _ngcontent-c27="" checked="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'foreign\')">Zahraničná platba <input _ngcontent-c27="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div></div><div _ngcontent-c27="" class="payment-options"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" class="cr0wdWidgetContent-popup-transfer" id="cr0wdWidgetContent-popup-transfer"><div _ngcontent-c27="">Platba na účet</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-cardPay"><input _ngcontent-c27="" name="payment-option" type="radio" value="2" class="cr0wdWidgetContent-popup-cardPay" id="cr0wdWidgetContent-popup-cardPay"><div _ngcontent-c27="">Platobná karta</div></label><label _ngcontent-c27="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-payBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" class="cr0wdWidgetContent-popup-payBySquare" id="cr0wdWidgetContent-popup-payBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><div _ngcontent-c27="" class="cft--monetization--bankTransfer"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c27="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c27="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c27="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Pokračovať do banky</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c27="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok po  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c27="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c27="" style="text-align:center;margin: 30px auto"><img _ngcontent-c27="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;">Ďakujeme. Vážime si vašu podporu.</h1></div><h4 _ngcontent-c27="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 15px; top: 15px; width: 20px; height: 20px; cursor: pointer; display: block;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(17, 75, 125);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }
        
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; } 
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:bold!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var landingDocument = document;
    // to work inside iframe
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTime(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--one-time\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateForm(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'#cft--monatization--form--donate--email\').checkValidity()
        && monetizationCont.querySelector(\'#cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
    // show comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    // hide cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
    // comfortpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
}
function trackInsertValue(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChange(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmit(el, event) {
    event.preventDefault();
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateForm(el)) {
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButton(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButton(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgress(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'.payment-option\').dataset.id
    });
    var selectedId = monetizationCont.querySelector(\'input[name="payment-option"]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptions(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function step(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryType(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    var cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\');
    var bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptions(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
        }


    }

    private function getTabletResult($widgetId)
    {
        switch ($widgetId) {
            case 1:
                return '<link _ngcontent-c31="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c31="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: calc(100% + 140px); top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c31="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-landing" style="position: relative; height: 100vh; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px; background-position: center center; background-image: url(https://postoj.sk/uploads/13462/conversions/cover.jpg);"><div _ngcontent-c31="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c31="" ng-reflect-ng-class="[object Object]" class="container"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c31="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(255, 255, 255); height: auto; overflow: hidden;"><div _ngcontent-c31="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c31="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 32px; color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: auto; background-color: rgba(0, 0, 0, 0);"></div><div _ngcontent-c31="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><!----><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c31="" class="preview-monetization" _nghost-c43="" ng-reflect-widget="[object Object]" ng-reflect-device-type="tablet"><link _ngcontent-c43="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 532px; height: auto; background-color: rgb(255, 255, 255); margin: 100px 0px 5px 5px;"><div _ngcontent-c43="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c43="" class="step-back cft--monatization--hidden" onclick="parent.stepClassic(this, false)"></span><span _ngcontent-c43="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c43="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 25px 55px;"><div _ngcontent-c43="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<div style=\"font-family: &quot"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><div><span>Píšeme len vďaka vašej podpore.</span></div><div><span>Ďakujeme.</span></div></h2></div><div _ngcontent-c43="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="30"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="20"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="15"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="10"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="5"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly custom" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this, true)" oninput="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="iná suma" style="font-size: 16px; font-weight: 400; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: white; width: 100%; height: 100%; color: rgb(31, 78, 123);"></div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="200"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="120"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 120  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="60"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="30"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="20"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time custom" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this, true)" oninput="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="iná suma" style="font-size: 16px; font-weight: 400; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: white; width: 100%; height: 100%; color: rgb(31, 78, 123);"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c43="" class="cft--monatization--membership-checkbox cft--monatization--membership-checkbox--monthly active" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c43="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; width: 100%; max-width: 100%; min-height: 34px;"><span>S podporou&nbsp;</span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span><br></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c43="" class="cft--monatization--membership-checkbox cft--monatization--membership-checkbox--one-time active" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c43="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; width: 100%; max-width: 100%; min-height: 34px;"><span>S jednorazovou podporou&nbsp;</span><span><b>120 € a viac sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><form _ngcontent-c43="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmitClassic(this, event)"><div _ngcontent-c43="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px; font-size: 16px;"><label _ngcontent-c43="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c43="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChangeClassic(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: rgb(85, 85, 85); padding: 6px; width: 100%; font-size: 16px; height: 45px;"><label _ngcontent-c43="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Zadaný email je v nesprávnom tvare.</label></div><div _ngcontent-c43="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px; font-size: 16px;"><input _ngcontent-c43="" name="terms_agreed" required="" type="checkbox" value="0" id="cft--monatization--form--donate--terms--1--"><label _ngcontent-c43="" style="display: inline; padding-left: 6px;" for="cft--monatization--form--donate--terms--1--"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c43="" class="error" ng-reflect-ng-style="[object Object]" id="cft--monatization--form--donate--terms-error--1--" for="cft--monatization--form--donate--terms--1--" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><button _ngcontent-c43="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c43="" href="javascript:void(0)" onclick="parent.oneTimePaymentClassic(this)" ng-reflect-ng-style="[object Object]" style="text-decoration: underline; color: rgb(35, 147, 232); font-size: 16px;">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c43="" href="javascript:void(0)" onclick="parent.monthlyPaymentClassic(this)" ng-reflect-ng-style="[object Object]" style="text-decoration: underline; color: rgb(35, 147, 232); font-size: 16px;">Pravidelná podpora</a></div></div><div _ngcontent-c43="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;">title</h2></div><input _ngcontent-c43="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c43="" class="cft--monetization--nationalPayment"><div _ngcontent-c43="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c43="" onclick="parent.paymentCountryTypeClassic(this, \'home\')">Domáca platba <input _ngcontent-c43="" checked="" type="radio" name="nationalPayment--1--null" id="home--1--null"><span _ngcontent-c43="" class="checkmark"></span></label></div><div _ngcontent-c43="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c43="" onclick="parent.paymentCountryTypeClassic(this, \'foreign\')">Zahraničná platba <input _ngcontent-c43="" type="radio" name="nationalPayment--1--null" id="abroad--1--null"><span _ngcontent-c43="" class="checkmark"></span></label></div></div><div _ngcontent-c43="" class="payment-options"><label _ngcontent-c43="" class="payment-options__button" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-transfer--1--null"><input _ngcontent-c43="" checked="checked" type="radio" value="1" name="payment-option--1--null" class="cr0wdWidgetContent-landing-transfer" id="cr0wdWidgetContent-landing-transfer--1--null"><div _ngcontent-c43="">Platba na účet</div></label><label _ngcontent-c43="" class="payment-options__button" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-cardPay--1--null"><input _ngcontent-c43="" type="radio" value="2" name="payment-option--1--null" class="cr0wdWidgetContent-landing-cardPay" id="cr0wdWidgetContent-landing-cardPay--1--null"><div _ngcontent-c43="">Platobná karta</div><div _ngcontent-c43="" class="cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="font-size: 12px; color: rgb(85, 85, 85);">(automatické obnovovanie)</div></label><label _ngcontent-c43="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-payBySquare--1--null"><input _ngcontent-c43="" type="radio" value="3" name="payment-option--1--null" class="cr0wdWidgetContent-landing-payBySquare" id="cr0wdWidgetContent-landing-payBySquare--1--null"><div _ngcontent-c43="">Pay by square</div></label></div><div _ngcontent-c43="" class="payment-option" data-id="1"><div _ngcontent-c43="" class="cft--monetization--bankTransfer"><table _ngcontent-c43="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c43=""><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">IBAN</td><td _ngcontent-c43="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Var. symbol</td><td _ngcontent-c43="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Suma</td><td _ngcontent-c43="" class="payment-value"><span _ngcontent-c43="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c43="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c43="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c43="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c43="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c43="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c43="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Go to your bank</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c43="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok  <span _ngcontent-c43="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c43="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c43="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c43="" style="text-align:center;margin: 30px auto"><img _ngcontent-c43="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><div _ngcontent-c43="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Go to your bank</div></div></div><div _ngcontent-c43="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 21px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;">Thank you for your support</h1></div><h4 _ngcontent-c43="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c43="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c43=""><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">IBAN</td><td _ngcontent-c43="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Var. symbol</td><td _ngcontent-c43="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Suma</td><td _ngcontent-c43="" class="payment-value"><span _ngcontent-c43="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c43="" style="text-align: center"> To get all rewards please  fill your personal data in My profile </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!----><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c31="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 7px; top: 7px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c31="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c31="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c31="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c31="" id="icon" transform="translate(5 5)"><path _ngcontent-c31="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(255, 255, 255);"></path></g></g></svg></span></div><div _ngcontent-c31="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c31="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }

            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }

            [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button:after {
                    content: \'€\';
                    position: absolute;
                    top: 23px;
                    right: 25px;
                    font-size: 16px;
                    font-family: Arial,Verdana,sans-serif;
                    color: #1f4e7b;
            }
           [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button input:focus::placeholder {
                    color:transparent;
           }

            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; }
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--container a {
    text-decoration: underline !important;
    }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:Medium!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c31="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthlyClassic(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var header = chosenButton.closest(\'.cft--monetization--container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = header.getElementsByClassName(\'cft--monatization--membership-checkbox--monthly\')[0];
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValueClassic(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTimeClassic(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var header = chosenButton.closest(\'.cft--monetization--container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = header.getElementsByClassName(\'cft--monatization--membership-checkbox--one-time\')[0];
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValueClassic(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateFormClassic(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity()
        && monetizationCont.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checkValidity();
    return validInput;
}
function oneTimePaymentClassic(el) {
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var choosedPaymentTypes = monetizationEl.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = monetizationEl.querySelector(\'#cft--monatization--donation--one-time\');
    var monthlyButton = monetizationEl.querySelector(\'#cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    monetizationEl.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    monetizationEl.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    monetizationEl.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    monetizationEl.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPaymentClassic(el) {
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var choosedPaymentTypes = monetizationEl.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = monetizationEl.querySelector(\'#cft--monatization--donation--one-time\');
    var monthlyButton = monetizationEl.querySelector(\'#cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
}
function trackInsertValueClassic(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChangeClassic(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmitClassic(el, event) {
    event.preventDefault();
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateFormClassic(el)) {
        monetizationEl.querySelector(\'.cft--monetization--container-step-1 button[type="submit"]\').classList.add(\'cft--monatization--hidden\');
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').value,
            \'email_valid\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity(),
            \'terms\': el.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStepClassic(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').value,
            \'email_valid\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity(),
            \'terms\': el.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStepClassic(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtonsClassic(monetizationEl, bankButtons);
    stepClassic(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButtonClassic(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtonsClassic(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButtonClassic(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButtonClassic(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButtonClassic(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgressClassic(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'input[name*=payment-option]:checked\').value
    });
    var selectedId = monetizationCont.querySelector(\'input[name*=payment-option]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            stepClassic(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptionsClassic(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name*="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function stepClassic(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
        monetizationCont.querySelector(\'.cft__cta__button\').classList.remove(\'cft--monatization--hidden\');
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryTypeClassic(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    // const cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\') as any;
    // const bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\') as any;
    var cardPayOptions = monetizationCont.querySelectorAll(\'input[name="payment-option"][value="2"]\');
    var bankTransferOptions = monetizationCont.querySelectorAll(\'input[name="payment-option"][value="1"]\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptionsClassic(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
        monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
        console.log(\'VALUEE \' + monetizationCont.querySelector(\'.payment-options__button input:checked\').value);
        if (monetizationCont.querySelector(\'.payment-options__button input:checked\').value === \'2\') {
            monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
        }
        else {
            monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.add(\'cft--monatization--hidden\');
        }
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
            case 3:
                return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-leaderboard" style="position: relative; height: auto; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px 15px;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(255, 255, 255); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c14="" ng-reflect-ng-class="[object Object]"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(0, 135, 237); height: auto; overflow: hidden;"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 24px; color: rgb(0, 135, 237); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: 15px auto auto; background-color: rgba(0, 0, 0, 0);"><span><b>Mohli by ste nás podporiť aj pravidelne?</b></span></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 16px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 10px auto 0px; color: rgb(0, 0, 0);"><b>8 z 10 našich podporovateľov nás podporuje pravidelne. </b>Vďaka pravideľným platbám môžeme lepšie plánovať prácu našej redakcie a s väčším pokojom tvoríme Postoj.&nbsp;</div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="tablet"><link _ngcontent-c27="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 15px 0px 5px 5px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": null
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="120"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 120 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 € </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 16.6667%; max-width: 16.6667%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%;"><span>S podporou&nbsp;</span><b><span>10 € a viac mesačne sa stávate členom Klubu Postoj</span><span>&nbsp;</span></b><div>a získavate naše špeciálne tlačené vydanie.</div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%;"><span>S podporou&nbsp;</span><b><span>120 € a viac sa stávate členom Klubu Postoj</span><span>&nbsp;</span></b><div>a získavate naše špeciálne tlačené vydanie.</div></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 10px 70px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Pravidelná podpora</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><span>Údaje k platbe</span></h2></div><input _ngcontent-c27="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c27="" class="cft--monetization--nationalPayment"><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'home\')">Domáca platba <input _ngcontent-c27="" checked="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'foreign\')">Zahraničná platba <input _ngcontent-c27="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div></div><div _ngcontent-c27="" class="payment-options"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" class="cr0wdWidgetContent-leaderboard-transfer" id="cr0wdWidgetContent-leaderboard-transfer"><div _ngcontent-c27="">Platba na účet</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-cardPay"><input _ngcontent-c27="" name="payment-option" type="radio" value="2" class="cr0wdWidgetContent-leaderboard-cardPay" id="cr0wdWidgetContent-leaderboard-cardPay"><div _ngcontent-c27="">Platobná karta</div></label><label _ngcontent-c27="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-payBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" class="cr0wdWidgetContent-leaderboard-payBySquare" id="cr0wdWidgetContent-leaderboard-payBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><div _ngcontent-c27="" class="cft--monetization--bankTransfer"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c27="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c27="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c27="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 10px 70px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať do banky</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 10px 70px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c27="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok po  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c27="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c27="" style="text-align:center;margin: 30px auto"><img _ngcontent-c27="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 10px 70px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><span>Ďakujeme. Vážime si vašu podporu.</span></h1></div><h4 _ngcontent-c27="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 10px 70px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 7px; top: 7px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(0, 135, 237);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }
        
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; } 
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:bold!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var landingDocument = document;
    // to work inside iframe
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTime(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--one-time\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateForm(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'#cft--monatization--form--donate--email\').checkValidity()
        && monetizationCont.querySelector(\'#cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
    // show comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    // hide cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
    // comfortpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
}
function trackInsertValue(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChange(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmit(el, event) {
    event.preventDefault();
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateForm(el)) {
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButton(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButton(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgress(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'.payment-option\').dataset.id
    });
    var selectedId = monetizationCont.querySelector(\'input[name="payment-option"]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptions(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function step(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryType(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    var cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\');
    var bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptions(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
            case 4:
                return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: block; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-popup" style="position: fixed; height: auto; width: 500px; max-width: 100%; top: 5%; bottom: auto; left: calc(50% - 250px); margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px 30px; z-index: 99999;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(255, 255, 255); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c14="" ng-reflect-ng-class="[object Object]"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(17, 75, 125); height: auto; overflow: hidden;"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 20px; color: rgb(17, 75, 125); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: 0px auto; background-color: rgba(0, 0, 0, 0);"><br></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="tablet"><link _ngcontent-c27="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 0px 0px 5px 5px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<div style=\"font-family: Lato,"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><div><span>Píšeme len vďaka vašej podpore.</span></div><div><span>Ďakujeme.</span></div></h2></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 100%;"><span>S podporou<b>&nbsp;</b></span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj&nbsp;</b></span><span>a získavate naše špeciálne tlačené vydanie.</span><br></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 100%;"><span>S jednorazovou podporou&nbsp;</span><span><b>120 € a viac sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Pravidelná podpora</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><span>Údaje k platbe</span></h2></div><input _ngcontent-c27="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c27="" class="cft--monetization--nationalPayment"><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'home\')">Domáca platba <input _ngcontent-c27="" checked="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'foreign\')">Zahraničná platba <input _ngcontent-c27="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div></div><div _ngcontent-c27="" class="payment-options"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" class="cr0wdWidgetContent-popup-transfer" id="cr0wdWidgetContent-popup-transfer"><div _ngcontent-c27="">Platba na účet</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-cardPay"><input _ngcontent-c27="" name="payment-option" type="radio" value="2" class="cr0wdWidgetContent-popup-cardPay" id="cr0wdWidgetContent-popup-cardPay"><div _ngcontent-c27="">Platobná karta</div></label><label _ngcontent-c27="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-payBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" class="cr0wdWidgetContent-popup-payBySquare" id="cr0wdWidgetContent-popup-payBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><div _ngcontent-c27="" class="cft--monetization--bankTransfer"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c27="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c27="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c27="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať do banky</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c27="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok po  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c27="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c27="" style="text-align:center;margin: 30px auto"><img _ngcontent-c27="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 25px; margin: 15px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><span>Ďakujeme. Vážime si vašu podporu.</span></h1></div><h4 _ngcontent-c27="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 7px; top: 7px; width: 20px; height: 20px; cursor: pointer; display: block;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(17, 75, 125);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }
        
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; } 
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:bold!important;
            background-color:#B71100!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var landingDocument = document;
    // to work inside iframe
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTime(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--one-time\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateForm(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'#cft--monatization--form--donate--email\').checkValidity()
        && monetizationCont.querySelector(\'#cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
    // show comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    // hide cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
    // comfortpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
}
function trackInsertValue(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChange(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmit(el, event) {
    event.preventDefault();
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateForm(el)) {
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButton(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButton(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgress(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'.payment-option\').dataset.id
    });
    var selectedId = monetizationCont.querySelector(\'input[name="payment-option"]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptions(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function step(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryType(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    var cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\');
    var bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptions(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
        }

    }

    private function getMobileResult($widgetId)
    {
        switch ($widgetId) {
            case 1:
                return '<link _ngcontent-c31="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c31="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: calc(100% + 140px); top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c31="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-landing" style="position: relative; height: 688px; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px; background-position: center center; background-image: url(&quot;http://127.0.0.1:8001/public/images/widgets/landing.jpg&quot;);"><div _ngcontent-c31="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c31="" ng-reflect-ng-class="[object Object]" class="container"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c31="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(255, 255, 255); height: auto; overflow: hidden;"><div _ngcontent-c31="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c31="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 32px; color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: auto; background-color: rgba(0, 0, 0, 0);"></div><div _ngcontent-c31="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><!----><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c31="" class="preview-monetization" _nghost-c43="" ng-reflect-widget="[object Object]" ng-reflect-device-type="mobile"><link _ngcontent-c43="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: auto; height: auto; background-color: rgb(255, 255, 255); margin: 40px 0px 5px 5px;"><div _ngcontent-c43="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c43="" class="step-back cft--monatization--hidden" onclick="parent.stepClassic(this, false)"></span><span _ngcontent-c43="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c43="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 24px;"><div _ngcontent-c43="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<div style=\"font-family: &quot"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 16px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 16px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><div><span>Píšeme len vďaka vašej podpore.</span></div><div><span>Ďakujeme.</span></div></h2></div><div _ngcontent-c43="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="30"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="20"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="15"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="10"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="5"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5  </div><div _ngcontent-c43="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly custom" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthlyClassic(this, true)" oninput="parent.setActiveButtonMonthlyClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="iná suma" style="font-size: 16px; font-weight: 400; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: white; width: 100%; height: 100%; color: rgb(31, 78, 123);"></div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="200"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="100"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="60"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="30"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div></div></div><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 15px 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" type="hidden" value="20"><div _ngcontent-c43="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time custom" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column; position: relative;"><div _ngcontent-c43="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTimeClassic(this, true)" oninput="parent.setActiveButtonOneTimeClassic(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c43="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="iná suma" style="font-size: 16px; font-weight: 400; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: white; width: 100%; height: 100%; color: rgb(31, 78, 123);"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c43="" class="cft--monatization--membership-checkbox cft--monatization--membership-checkbox--monthly active" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c43="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; width: 100%; max-width: 100%; min-height: 34px;"><span>S podporou&nbsp;</span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span><br></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c43="" class="cft--monatization--membership-checkbox cft--monatization--membership-checkbox--one-time active" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c43="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; width: 100%; max-width: 100%; min-height: 34px;"><span>S jednorazovou podporou<b>&nbsp;</b></span><span><b>120 € a viac sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><form _ngcontent-c43="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmitClassic(this, event)"><div _ngcontent-c43="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px; font-size: 16px;"><label _ngcontent-c43="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c43="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChangeClassic(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: rgb(85, 85, 85); padding: 6px; width: 100%; font-size: 16px; height: 45px;"><label _ngcontent-c43="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Zadaný email je v nesprávnom tvare.</label></div><div _ngcontent-c43="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px; font-size: 16px;"><input _ngcontent-c43="" name="terms_agreed" required="" type="checkbox" value="0" id="cft--monatization--form--donate--terms--1--"><label _ngcontent-c43="" style="display: inline; padding-left: 6px;" for="cft--monatization--form--donate--terms--1--"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c43="" class="error" ng-reflect-ng-style="[object Object]" id="cft--monatization--form--donate--terms-error--1--" for="cft--monatization--form--donate--terms--1--" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><button _ngcontent-c43="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c43="" href="javascript:void(0)" onclick="parent.oneTimePaymentClassic(this)" ng-reflect-ng-style="[object Object]" style="text-decoration: underline; color: rgb(35, 147, 232); font-size: 16px;">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c43="" href="javascript:void(0)" onclick="parent.monthlyPaymentClassic(this)" ng-reflect-ng-style="[object Object]" style="text-decoration: underline; color: rgb(35, 147, 232); font-size: 16px;">Pravidelná podpora</a></div></div><div _ngcontent-c43="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 16px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 16px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;">title</h2></div><input _ngcontent-c43="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c43="" class="cft--monetization--nationalPayment"><div _ngcontent-c43="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c43="" onclick="parent.paymentCountryTypeClassic(this, \'home\')">Domáca platba <input _ngcontent-c43="" checked="" type="radio" name="nationalPayment--1--null" id="home--1--null"><span _ngcontent-c43="" class="checkmark"></span></label></div><div _ngcontent-c43="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c43="" onclick="parent.paymentCountryTypeClassic(this, \'foreign\')">Zahraničná platba <input _ngcontent-c43="" type="radio" name="nationalPayment--1--null" id="abroad--1--null"><span _ngcontent-c43="" class="checkmark"></span></label></div></div><div _ngcontent-c43="" class="payment-options"><label _ngcontent-c43="" class="payment-options__button" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-transfer--1--null"><input _ngcontent-c43="" checked="checked" type="radio" value="1" name="payment-option--1--null" class="cr0wdWidgetContent-landing-transfer" id="cr0wdWidgetContent-landing-transfer--1--null"><div _ngcontent-c43="">Platba na účet</div></label><label _ngcontent-c43="" class="payment-options__button" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-cardPay--1--null"><input _ngcontent-c43="" type="radio" value="2" name="payment-option--1--null" class="cr0wdWidgetContent-landing-cardPay" id="cr0wdWidgetContent-landing-cardPay--1--null"><div _ngcontent-c43="">Platobná karta</div><div _ngcontent-c43="" class="cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="font-size: 12px; color: rgb(85, 85, 85);">(automatické obnovovanie)</div></label><label _ngcontent-c43="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptionsClassic(this)" style="cursor: pointer" for="cr0wdWidgetContent-landing-payBySquare--1--null"><input _ngcontent-c43="" type="radio" value="3" name="payment-option--1--null" class="cr0wdWidgetContent-landing-payBySquare" id="cr0wdWidgetContent-landing-payBySquare--1--null"><div _ngcontent-c43="">Pay by square</div></label></div><div _ngcontent-c43="" class="payment-option" data-id="1"><div _ngcontent-c43="" class="cft--monetization--bankTransfer"><table _ngcontent-c43="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c43=""><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">IBAN</td><td _ngcontent-c43="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Var. symbol</td><td _ngcontent-c43="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Suma</td><td _ngcontent-c43="" class="payment-value"><span _ngcontent-c43="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c43="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c43="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c43="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c43="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c43="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c43="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Go to your bank</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c43="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok  <span _ngcontent-c43="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c43="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c43="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c43="" style="text-align:center;margin: 30px auto"><img _ngcontent-c43="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><div _ngcontent-c43="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgressClassic(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Go to your bank</div></div></div><div _ngcontent-c43="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 16px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c43="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 16px; margin: 0px 0px 30px; color: rgb(31, 78, 123); text-align: center;">Thank you for your support</h1></div><h4 _ngcontent-c43="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c43="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c43=""><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">IBAN</td><td _ngcontent-c43="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Var. symbol</td><td _ngcontent-c43="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c43=""><td _ngcontent-c43="" class="payment-title">Suma</td><td _ngcontent-c43="" class="payment-value"><span _ngcontent-c43="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c43="" style="text-align: center"> To get all rewards please  fill your personal data in My profile </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c43="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c43="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 0px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 21px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 4px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!----><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c31="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 25px; top: 0px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c31="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c31="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c31="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c31="" id="icon" transform="translate(5 5)"><path _ngcontent-c31="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(255, 255, 255);"></path></g></g></svg></span></div><div _ngcontent-c31="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c31="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }

            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }

            [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button:after {
                    content: \'€\';
                    position: absolute;
                    top: 23px;
                    right: 25px;
                    font-size: 16px;
                    font-family: Arial,Verdana,sans-serif;
                    color: #1f4e7b;
            }
           [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button input:focus::placeholder {
                    color:transparent;
           }

            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; }
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--container a {
    text-decoration: underline !important;
    }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:Medium!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c31="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthlyClassic(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var header = chosenButton.closest(\'.cft--monetization--container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = header.getElementsByClassName(\'cft--monatization--membership-checkbox--monthly\')[0];
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValueClassic(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTimeClassic(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var header = chosenButton.closest(\'.cft--monetization--container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = header.getElementsByClassName(\'cft--monatization--membership-checkbox--one-time\')[0];
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValueClassic(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateFormClassic(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity()
        && monetizationCont.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checkValidity();
    return validInput;
}
function oneTimePaymentClassic(el) {
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var choosedPaymentTypes = monetizationEl.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = monetizationEl.querySelector(\'#cft--monatization--donation--one-time\');
    var monthlyButton = monetizationEl.querySelector(\'#cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    monetizationEl.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    monetizationEl.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    monetizationEl.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    monetizationEl.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPaymentClassic(el) {
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var choosedPaymentTypes = monetizationEl.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = monetizationEl.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = monetizationEl.querySelector(\'#cft--monatization--donation--one-time\');
    var monthlyButton = monetizationEl.querySelector(\'#cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
}
function trackInsertValueClassic(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChangeClassic(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmitClassic(el, event) {
    event.preventDefault();
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateFormClassic(el)) {
        monetizationEl.querySelector(\'.cft--monetization--container-step-1 button[type="submit"]\').classList.add(\'cft--monatization--hidden\');
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').value,
            \'email_valid\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity(),
            \'terms\': el.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStepClassic(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').value,
            \'email_valid\': el.querySelector(\'[id*=cft--monatization--form--donate--email]\').checkValidity(),
            \'terms\': el.querySelector(\'[id*=cft--monatization--form--donate--terms]\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStepClassic(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtonsClassic(monetizationEl, bankButtons);
    stepClassic(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButtonClassic(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtonsClassic(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButtonClassic(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButtonClassic(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButtonClassic(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgressClassic(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'input[name*=payment-option]:checked\').value
    });
    var selectedId = monetizationCont.querySelector(\'input[name*=payment-option]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            stepClassic(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptionsClassic(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name*="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function stepClassic(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
        monetizationCont.querySelector(\'.cft__cta__button\').classList.remove(\'cft--monatization--hidden\');
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryTypeClassic(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    // const cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\') as any;
    // const bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\') as any;
    var cardPayOptions = monetizationCont.querySelectorAll(\'input[name="payment-option"][value="2"]\');
    var bankTransferOptions = monetizationCont.querySelectorAll(\'input[name="payment-option"][value="1"]\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptionsClassic(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
        monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
        monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
        console.log(\'VALUEE \' + monetizationCont.querySelector(\'.payment-options__button input:checked\').value);
        if (monetizationCont.querySelector(\'.payment-options__button input:checked\').value === \'2\') {
            monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.remove(\'cft--monatization--hidden\');
        }
        else {
            monetizationCont.querySelector(\'.payment-option[data-id="1"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.payment-option[data-id="2"]\').classList.add(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="1"]\').classList.remove(\'cft--monatization--hidden\');
            monetizationCont.querySelector(\'.cft--button-container[data-id="2"]\').classList.add(\'cft--monatization--hidden\');
        }
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
            case 3:
                return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-leaderboard" style="position: relative; height: auto; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 15px;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(255, 255, 255); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c14="" ng-reflect-ng-class="[object Object]"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(0, 135, 237); height: auto; overflow: hidden;"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 20px; color: rgb(0, 135, 237); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: 0px auto auto; background-color: rgba(0, 0, 0, 0);"><span><b>Mohli by ste nás podporiť aj pravidelne?</b></span></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 13px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 10px auto; color: rgb(0, 0, 0);"><span><b>8 z 10 našich podporovateľov nás podporuje pravidelne.</b></span><span><b>&nbsp;</b>Vďaka pravideľným platbám môžeme lepšie plánovať prácu našej redakcie a s väčším pokojom tvoríme Postoj.&nbsp;</span></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="mobile"><link _ngcontent-c27="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 0px 0px 5px 5px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": null
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5  </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> € mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10  </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> € mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15  </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> € mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20  </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> € mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30  </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> € mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> € mesačne </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 € </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%;"><span>S podporou&nbsp;</span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj&nbsp;</b></span><div><span>a získavate naše špeciálne tlačené vydanie.</span></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%;"><span>S podporou&nbsp;</span><span><b>120 € a viac sa stávate členom Klubu Postoj&nbsp;</b></span><div>a získavate naše špeciálne tlačené vydanie.</div></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 7px 70px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Pravidelná podpora</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><span>Údaje k platbe</span></h2></div><input _ngcontent-c27="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c27="" class="cft--monetization--nationalPayment"><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'home\')">Domáca platba <input _ngcontent-c27="" checked="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'foreign\')">Zahraničná platba <input _ngcontent-c27="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div></div><div _ngcontent-c27="" class="payment-options"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" class="cr0wdWidgetContent-leaderboard-transfer" id="cr0wdWidgetContent-leaderboard-transfer"><div _ngcontent-c27="">Platba na účet</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-cardPay"><input _ngcontent-c27="" name="payment-option" type="radio" value="2" class="cr0wdWidgetContent-leaderboard-cardPay" id="cr0wdWidgetContent-leaderboard-cardPay"><div _ngcontent-c27="">Platobná karta</div></label><label _ngcontent-c27="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-leaderboard-payBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" class="cr0wdWidgetContent-leaderboard-payBySquare" id="cr0wdWidgetContent-leaderboard-payBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><div _ngcontent-c27="" class="cft--monetization--bankTransfer"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c27="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c27="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c27="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 7px 70px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať do banky</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 7px 70px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c27="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok po  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c27="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c27="" style="text-align:center;margin: 30px auto"><img _ngcontent-c27="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 7px 70px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 0px; margin: 10px 0px; color: rgb(31, 78, 123); text-align: center;"><span>Ďakujeme. Vážime si vašu podporu.</span></h1></div><h4 _ngcontent-c27="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 20px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="padding: 7px 70px 10px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 25px; top: 0px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(0, 135, 237);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }
        
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; } 
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:bold!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var landingDocument = document;
    // to work inside iframe
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTime(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--one-time\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateForm(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'#cft--monatization--form--donate--email\').checkValidity()
        && monetizationCont.querySelector(\'#cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
    // show comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    // hide cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
    // comfortpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
}
function trackInsertValue(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChange(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmit(el, event) {
    event.preventDefault();
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateForm(el)) {
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButton(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButton(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgress(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'.payment-option\').dataset.id
    });
    var selectedId = monetizationCont.querySelector(\'input[name="payment-option"]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptions(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function step(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryType(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    var cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\');
    var bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptions(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
            case 4:
                return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: block; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-popup" style="position: fixed; height: 100vh; width: 100%; max-width: 100%; top: 0px; bottom: auto; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px; z-index: 99999;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(255, 255, 255); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><div _ngcontent-c14="" ng-reflect-ng-class="[object Object]"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: relative; width: 100%; margin: 0px auto; color: rgb(17, 75, 125); height: 95vh; overflow: hidden auto;"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; color: rgb(17, 75, 125); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: 0px auto; background-color: rgba(0, 0, 0, 0);"><br></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="mobile"><link _ngcontent-c27="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|&quot;Roboto Slab&quot;, sans-serif"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="box-shadow: none; color: rgb(31, 78, 123); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 0px 0px 5px 5px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(31, 78, 123); width: 100%; text-align: center; position: relative; height: auto; display: none;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Krok <span>1</span> z 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px 15px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<div style=\"font-family: Lato,"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 18px; margin: 15px 0px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 18px; margin: 15px 0px; color: rgb(31, 78, 123); text-align: center;"><div><span>Píšeme len vďaka vašej podpore.</span></div><div><span>Ďakujeme.</span></div></h2></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 € </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;">  mesačne </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -7px; margin-left: -7px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 € </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 € </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 50%; max-width: 50%; padding: 6px 7px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price hide-arrows" type="number" ng-reflect-ng-style="[object Object]" placeholder="vlastná" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 100%;"><span>S podporou&nbsp;</span><span><b>10 € a viac mesačne sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span><br></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px; max-width: 100%; width: 100%;"><span>S jednorazovou podporou&nbsp;</span><span><b>120 € a viac sa stávate členom Klubu Postoj</b><span>&nbsp;</span></span><span>a získavate naše špeciálne tlačené vydanie.</span></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Váš email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;"><span>Súhlasím so spracovaním osobných údajov.</span></label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;">Podporiť denník</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">Jednorazová podpora</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Pravidelná podpora</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 18px; margin: 15px 0px; color: rgb(31, 78, 123); text-align: center;"><h2 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 18px; margin: 15px 0px; color: rgb(31, 78, 123); text-align: center;"><span>Údaje k platbe</span></h2></div><input _ngcontent-c27="" name="choosedPaymentType" type="hidden" value="monthly"><div _ngcontent-c27="" class="cft--monetization--nationalPayment"><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'home\')">Domáca platba <input _ngcontent-c27="" checked="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div><div _ngcontent-c27="" class="cft--monetization--nationalPayment--country"><label _ngcontent-c27="" onclick="parent.paymentCountryType(this, \'foreign\')">Zahraničná platba <input _ngcontent-c27="" name="nationalPayment" type="radio"><span _ngcontent-c27="" class="checkmark"></span></label></div></div><div _ngcontent-c27="" class="payment-options"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" class="cr0wdWidgetContent-popup-transfer" id="cr0wdWidgetContent-popup-transfer"><div _ngcontent-c27="">Platba na účet</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-cardPay"><input _ngcontent-c27="" name="payment-option" type="radio" value="2" class="cr0wdWidgetContent-popup-cardPay" id="cr0wdWidgetContent-popup-cardPay"><div _ngcontent-c27="">Platobná karta</div></label><label _ngcontent-c27="" class="payment-options__button payment-options__button__pbs cft--monatization--hidden" onclick="parent.changePaymentOptions(this)" style="cursor: pointer" for="cr0wdWidgetContent-popup-payBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" class="cr0wdWidgetContent-popup-payBySquare" id="cr0wdWidgetContent-popup-payBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><div _ngcontent-c27="" class="cft--monetization--bankTransfer"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div></div><div _ngcontent-c27="" class="payment-option cft--monatization--hidden" data-id="2"><img _ngcontent-c27="" class="payment-option--cardPay--oneTime cft--monatization--hidden" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/cardpay.jpg" style="display: block; margin: 30px auto; max-width: 194px;"><img _ngcontent-c27="" class="payment-option--cardPay--monthly" ng-reflect-ng-style="[object Object]" src="http://localhost:4200/assets/images/payment/comfortpay.png" style="display: block; margin: 30px auto; max-width: 194px;"></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať do banky</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="2" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft--ctaButton--cardPay" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span _ngcontent-c27="" class="cft--ctaButton--cardPay--monthly"> Mesačný príspevok po  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span><span _ngcontent-c27="" class="cft--ctaButton--cardPay--oneTime cft--monatization--hidden"> Zaplatiť  <span _ngcontent-c27="" class="cft--ctaButton--cardPay--value"></span></span></a><div _ngcontent-c27="" style="text-align:center;margin: 30px auto"><img _ngcontent-c27="" src="http://localhost:4200/assets/images/payment/cards.jpg"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"><span>Pokračovať k platbe</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 18px; margin: 15px 0px; color: rgb(31, 78, 123); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="background-color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;, sans-serif; font-size: 18px; margin: 15px 0px; color: rgb(31, 78, 123); text-align: center;"><span>Ďakujeme. Vážime si vašu podporu.</span></h1></div><h4 _ngcontent-c27="" class="payment-table" style="text-align:center;">Rekapitulácia platobného príkazu</h4><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Suma</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span> €</td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center">  </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 8px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" href="/moj-ucet" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 10px 30px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: bold; text-align: center; color: rgb(255, 255, 255); font-size: 16px; display: inline-block; background-color: rgb(0, 135, 237); border: none; box-shadow: none; border-radius: 5px; cursor: pointer; transition: all 0.5s ease 0s; text-decoration: none;"> Prejdite do Vášho účtu </a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 25px; top: 0px; width: 20px; height: 20px; cursor: pointer; display: block;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(17, 75, 125);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #3cc300;
                    border-color: #32a300;
                }
        
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: #3cc300;
                    border: 1px solid #ffffff
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
            }
            
            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; } 
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }
            </style><style class="globalStyles" type="text/css">
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 100%;
        max-height: 100%;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
        cursor: pointer;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment {
   display: block;
   text-align: center;
   margin-bottom: 15px;
   padding-bottom: 15px;
   border-bottom: 1px solid #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment .cft--monetization--nationalPayment--country {
    display: inline-block;
    margin: 0 10px;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label {
   position: relative;
  padding-left: 27px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
   }
   
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input ~ .checkmark {
   position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #e7e9eb;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark {
   background-color: #114b7d !important;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input {
   position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
   display: block;
   }
   
   [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label input:checked ~ .checkmark:after {
    content: \'\';
    margin-left: 8px;
    margin-top: 5px;
    width: 5px;
    height: 9px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
   }
    
</style>
</style><style class="hoverStyles" type="text/css">
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:bold!important;
            background-color:#114b7d!important;
            opacity:1!important;
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 10
    var landingDocument = document;
    // to work inside iframe
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--monthly\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'monthly\', apiPublicUrl);
    }
};
function setActiveButtonOneTime(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 120
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById(\'cft-monetization__container\');
    var btns = header.getElementsByClassName(\'cft--monatization--donation-button--one-time\');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains(\'active\')) {
            btns[i].className = btns[i].className.replace(\' active\', \'\');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += \' active\';
        }
    }
    if (focusInput) {
        var inputs = chosenButton.getElementsByTagName(\'input\');
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    var checkbox = landingDocument.getElementById(\'cft--monatization--membership-checkbox--one-time\');
    if (chosenButton.getElementsByTagName(\'input\')[0].value >= target) {
        checkbox.className += \' active\';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, \'\');
    }
    if (track) {
        trackInsertValue(chosenButton, \'one-time\', apiPublicUrl);
    }
};
function validateForm(el) {
    var validInput = false;
    var monetizationCont = el.closest(\'.cft--monetization--container\');
    el.className += \' submitted\';
    validInput = monetizationCont.querySelector(\'#cft--monatization--form--donate--email\').checkValidity()
        && monetizationCont.querySelector(\'#cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'one-time\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, oneTimeElements_1 = oneTimeElements; _i < oneTimeElements_1.length; _i++) {
        var oneTime = oneTimeElements_1[_i];
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, monthlyElements_1 = monthlyElements; _a < monthlyElements_1.length; _a++) {
        var monthly = monthlyElements_1[_a];
        monthly.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        oneTimeButton.className += \' active\';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, \'\');
    }
    // hide comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    // show cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
    // cardpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.add(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.remove(\'cft--monatization--hidden\');
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var choosedPaymentTypes = landingDocument.querySelectorAll(\'input[name="choosedPaymentType"]\');
    for (var i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = \'monthly\';
    }
    var monthlyElements = landingDocument.getElementsByClassName(\'cft--monatization--only-monthly\');
    var oneTimeElements = landingDocument.getElementsByClassName(\'cft--monatization--only-one-time\');
    for (var _i = 0, monthlyElements_2 = monthlyElements; _i < monthlyElements_2.length; _i++) {
        var monthly = monthlyElements_2[_i];
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    for (var _a = 0, oneTimeElements_2 = oneTimeElements; _a < oneTimeElements_2.length; _a++) {
        var oneTime = oneTimeElements_2[_a];
        oneTime.className += \' cft--monatization--hidden\';
    }
    // for lite monetization
    var oneTimeButton = landingDocument.getElementById(\'cft--monatization--donation--one-time\');
    var monthlyButton = landingDocument.getElementById(\'cft--monatization--donation--monthly\');
    if (oneTimeButton) {
        monthlyButton.className += \' active\';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, \'\');
    }
    // show comfortpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    // hide cardpay logo
    landingDocument.querySelector(\'.payment-option--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
    // comfortpay button text
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--monthly\').classList.remove(\'cft--monatization--hidden\');
    landingDocument.querySelector(\'.cft--ctaButton--cardPay--oneTime\').classList.add(\'cft--monatization--hidden\');
}
function trackInsertValue(chosenButton, frequency, apiUrl) {
    var xhttp = new XMLHttpRequest();
    var data = JSON.stringify({
        \'value\': chosenButton.getElementsByTagName(\'input\')[0].value,
        \'frequency\': frequency,
        \'show_id\': chosenButton.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId
    });
    xhttp.open(\'POST\', apiUrl + \'tracking/insertValue\', true);
    xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhttp.responseType = \'json\';
    xhttp.send(data);
}
function trackEmailOnChange(el) {
    // TODO: get from  env
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    if (el.checkValidity()) {
        var xhttp = new XMLHttpRequest();
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.value,
            \'email_valid\': el.checkValidity()
        });
        xhttp.open(\'POST\', apiPublicUrl + \'tracking/insertEmail\', true);
        xhttp.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhttp.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhttp.responseType = \'json\';
        xhttp.send(data);
    }
}
function handleSubmit(el, event) {
    event.preventDefault();
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var monetizationEl = el.closest(\'.cft--monetization--container\');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName(\'cft--monatization--donation-button-wrapper\');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf(\'cft--monatization--hidden\') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = \'unknown. Maybe error. Please check class names of elements that are used in monetization component\';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-monthly\') > -1) {
        frequency = \'monthly\';
    }
    if (currentActiveWrapper.className.indexOf(\'cft--monatization--only-one-time\') > -1) {
        frequency = \'one-time\';
    }
    var selectedValue;
    if (frequency === \'monthly\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--monthly.active input\').value;
    }
    if (frequency === \'one-time\') {
        selectedValue = monetizationEl.querySelector(\'.cft--monatization--donation-button--one-time.active input\').value;
    }
    if (validateForm(el)) {
        var formData_1 = new FormData(el);
        var data = JSON.stringify({
            \'referral_widget_id\': location.search.substr(1).split(\'referral_widget_id=\')[1],
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        monetizationEl.querySelectorAll(\'.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value\').forEach(function (elem) {
            elem.innerHTML = selectedValue + \' €\';
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.cardPayURL, xhr_1.response.comfortPayURL, xhr_1.response.user_token, xhr_1.response.donation_id);
            }
        };
        xhr_1.open(\'POST\', apiPublicUrl + \'donation/initialize\', true);
        xhr_1.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr_1.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr_1.responseType = \'json\';
        xhr_1.send(data);
    }
    else {
        var formData = new FormData(el);
        var data = JSON.stringify({
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', apiPublicUrl + \'tracking/initialize-donation-invalid\', true);
        xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
        xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
        xhr.responseType = \'json\';
        xhr.send(data);
    }
    return false;
}
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\');
    var vsStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\');
    var amountStep2 = monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : \'\';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : \'\';
    amountStep2 ? amountStep2.innerHTML = value : \'\';
    var ibanStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\');
    var vsStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\');
    var amountStep3 = monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : \'\';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : \'\';
    amountStep3 ? amountStep3.innerHTML = value : \'\';
    var paymentOptionButtonPBS = monetizationEl.querySelector(\'.payment-options__button__pbs\');
    var cardPayButton = monetizationEl.querySelector(\'.cft--ctaButton--cardPay\');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === \'one-time\') {
            paymentOptionButtonPBS.classList.remove(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', cardPayURL);
        }
        else {
            paymentOptionButtonPBS.classList.add(\'cft--monatization--hidden\');
            cardPayButton.setAttribute(\'href\', comfortPayURL);
        }
    }
    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);
    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector(\'.qr__wrapper .pay-by-square__wrapper\');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem(\'cft_usertoken\', userToken);
    }
}
function setBankButton(element) {
    var bankButtonWrapper = element.closest(\'.bank-button__wrapper\');
    var bankButtons = bankButtonWrapper.getElementsByClassName(\'bank-button\');
    for (var _i = 0, bankButtons_1 = bankButtons; _i < bankButtons_1.length; _i++) {
        var bankButton = bankButtons_1[_i];
        bankButton.className = bankButton.className.replace(/ active/g, \'\');
    }
    element.className += \' active\';
    //change href of anchor.
    var anchor = element.closest(\'.cft--monetization--container-step-2\').querySelector(\'.cft--button--redirect\');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(\':checked\').dataset.bankLink;
}
function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector(\'.bank-button__wrapper\');
    bankButtonsWrapper.innerHTML = \'\';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <span>" + bankButtonsData[i].title + "</span>\n                        </div> \n                  </div>");
        }
        else {
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\" style=\"max-height: 100%; max-width: 100%;\">\n                        </div> \n                  </div>");
        }
    }
    //create from 6th and later bank button select\'s option
    if (bankButtonsData.length > 5) {
        var options = "<div class=\"bank-button__container\">\n                <div class=\"bank-button bank-button__select\" onclick=\"parent.setBankButton(this)\">\n                    <select name=\"bank\">\n                        <option disabled=\"\" selected=\"\">Other bank</option>";
        for (var i = 5; i < bankButtonsData.length; i++) {
            options += "<option data-bank-link=\"" + bankButtonsData[i].redirect_link + "\">" + bankButtonsData[i].title + "</option>";
        }
        options += "\n                    </select>\n                </div>\n            </div>";
        bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', options);
    }
}
function donationInProgress(element) {
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\';
    var xhr = new XMLHttpRequest();
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var data = JSON.stringify({
        \'donation_id\': monetizationCont.dataset.donationId,
        \'payment_method_id\': monetizationCont.querySelector(\'.payment-option\').dataset.id
    });
    var selectedId = monetizationCont.querySelector(\'input[name="payment-option"]:checked\').value;
    if (selectedId === \'2\') {
        localStorage.setItem(\'cft--donation_via\', \'cardpay\');
    }
    else {
        localStorage.setItem(\'cft--donation_via\', \'\');
    }
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    };
    xhr.open(\'POST\', apiPublicUrl + \'donation/waiting-for-payment\', true);
    xhr.setRequestHeader(\'Authorization\', \'Bearer \' + localStorage.getItem(\'cft_usertoken\'));
    xhr.setRequestHeader(\'Content-type\', \'application/json; charset=utf-8\');
    xhr.responseType = \'json\';
    xhr.send(data);
}
function changePaymentOptions(element) {
    var monetizationStep = element.closest(\'.cft--monetization--container-step-2\');
    var paymentOptionArray = monetizationStep.getElementsByClassName(\'payment-option\');
    var selectedId = monetizationStep.querySelector(\'input[name="payment-option"]:checked\').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += \' cft--monatization--hidden\';
        }
        else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, \'\');
        }
    }
}
function step(element, increase) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var firstStep = monetizationCont.querySelector(\'.cft--monetization--container-step-1\');
    var secondStep = monetizationCont.querySelector(\'.cft--monetization--container-step-2\');
    var thirdStep = monetizationCont.querySelector(\'.cft--monetization--container-step-3\');
    var headTitle = monetizationCont.querySelector(\'.head .title\');
    var stepBack = monetizationCont.querySelector(\'.step-back\');
    var actualStep = parseInt(monetizationCont.querySelector(\'.head .title span\').textContent, 10);
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title span\').innerText = actualStep + 1;
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title span\').innerHTML = actualStep - 1;
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep + 1;
        stepBack.className = \'step-back\';
        monetizationCont.querySelector(\'.head\').classList.add(\'cft--monatization--hidden\');
        if (localStorage.getItem(\'cft--donation_via\') === \'cardpay\') {
            monetizationCont.querySelectorAll(\'.payment-table\').forEach(function (el, key) {
                el.style.setProperty(\'display\', \'none\', \'important\');
            });
        }
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = actualStep - 1;
    }
}
function paymentCountryType(element, type) {
    var monetizationCont = element.closest(\'.cft--monetization--container\');
    var els = monetizationCont.getElementsByClassName(\'cft--monetization--bankTransfer\');
    var choosedPaymentType = monetizationCont.querySelector(\'input[name="choosedPaymentType"]\');
    var cardPayOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-cardPay\');
    var bankTransferOptions = monetizationCont.getElementsByClassName(\'cr0wdWidgetContent-popup-transfer\');
    var paymentOptions = monetizationCont.querySelector(\'.payment-options\');
    if (type === \'foreign\' && choosedPaymentType.value === \'monthly\') {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.add(\'cft--monatization--hidden\');
        }
        for (var i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (var i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptions(cardPayOptions[i]);
        }
        paymentOptions.style.display = \'none\';
    }
    else {
        for (var i = 0; i < els.length; i++) {
            els[i].classList.remove(\'cft--monatization--hidden\');
        }
        paymentOptions.style.display = \'flex\';
    }
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
                break;
        }


    }

}
