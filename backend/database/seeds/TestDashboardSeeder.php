<?php

use Illuminate\Database\Seeder;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignPromote;
use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Payment\Entities\CampaignDonation;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Services\PaymentMethodsService;
use Modules\Payment\Services\PaymentService;
use Modules\Targeting\Entities\Targeting;
use Modules\UserManagement\Database\Seeders\PortalUserSeeder;
use Modules\UserManagement\Entities\DonorStatus;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\TrackingVisit;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\Campaigns\Entities\Widget;
use Carbon\Carbon;

class TestDashboardSeeder extends Seeder
{
    protected $variableSymbolService;
    protected $userGdprRepository;

    protected $paymentService;
    protected $paymentMehhodService;

    public function __construct(PaymentService $paymentService, PaymentMethodsService $paymentMehhodService)
    {
        $this->paymentService = $paymentService;
        $this->paymentMehhodService = $paymentMehhodService;
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create landing default campaign
        $this->landingDefaultCampaign();
//
//        //create 5 campaigns
        for ($i = 0; $i < 5; $i++) {
            $this->call(\Modules\Campaigns\Database\Seeders\CreateDummyCampaignSeeder::class);
        }

        $this->setImagesToCampaigns();
//
//        // create 600 users
        for ($i = 0; $i < 10; $i++) {
            $this->call(PortalUserSeeder::class);
        }
        $this->createArticles();
        $users = PortalUser::all();
        for ($i = 0; $i < 3; $i++) { // 2 iterations of generate payments for all users
            foreach ($users as $user) {
                $this->generateTrackingAndPayments($user->id, $user->created_at);
            }
        }
    }

    private function createArticles()
    {
        $trackingSites = array();
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/74/ked-george-soros-a-charles-koch-financuju-katolickeho-konzervativca',
            'article_id' => 74,
            'author' => 'Ferko Mrkvicka',
            'title' => 'Keď George Soros a Charles Koch financujú katolíckeho konzervatívca'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/73/klerofasisticke-pokusenie-ladislava-hanusa',
            'article_id' => 73,
            'author' => 'John Doe',
            'title' => 'Klérofašistické pokušenie Ladislava Hanusa'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/69/najvaecsia-reforma-smeru-v-zdravotnictve-za-dvanast-rokov-projekty-penty',
            'article_id' => 69,
            'author' => 'Peter Balbercak',
            'title' => 'Najväčšia reforma Smeru v zdravotníctve za dvanásť rokov? Projekty Penty'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/72/v-centre-bratislavy-vylupili-zlatnictvo-ukradli-sperky-za-viac-ako-50-tisic-eur',
            'article_id' => 72,
            'author' => 'Donald Trump',
            'title' => 'V centre Bratislavy vylúpili zlatníctvo, ukradli šperky za viac ako 50-tisíc eur'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/70/o-lobotku-udajne-prejavil-zaujem-ac-milano',
            'article_id' => 70,
            'author' => 'Bill Cosby',
            'title' => 'O Lobotku údajne prejavil záujem AC Miláno'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/68/zelensky-hovoril-s-putinom-aj-o-zajatych-ukrajinskych-namornikoch',
            'article_id' => 68,
            'author' => 'George Bush',
            'title' => 'Zelenský hovoril s Putinom aj o zajatých ukrajinských námorníkoch'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news',
            'article_id' => null,
            'title' => ''
        ));
        for ($i = 0; $i < sizeof($trackingSites); $i++) {
            if ($trackingSites[$i]['article_id'] !== null) {
                $articleCreated = Carbon::now()->subDays(150, 180);
                \Modules\Campaigns\Entities\Article::create([
                    'article_id' => $trackingSites[$i]['article_id'],
                    'author' => $trackingSites[$i]['author'],
                    'title' => $trackingSites[$i]['title'],
                    'article_created_at' => $articleCreated,
                    'created_at' => $articleCreated
                ]);
            }
        }
    }

    private function landingDefaultCampaign()
    {
        $campaign = Campaign::create([
            'name' => 'Default landing campaign',
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

        $widget = Widget::create([
            'campaign_id' => $campaign->id,
            'widget_type_id' => 1,
            'active' => true,
            'prevent_disable' => 'true'
        ]);

        $campaignPromote = CampaignPromote::create([
            'campaign_id' => $campaign->id,
            'start_date_value' => '2000-01-01',
            'is_end_date' => true,
            'end_date_value' => '2050-01-01',
        ]);

        $widgetSettings = WidgetSettings::create([
            'widget_id' => $widget->id,
            'desktop' => $this->getDesktopSettings(),
            'tablet' => $this->getTabletSettings(),
            'mobile' => $this->getMobileSettings()
        ]);

        $widgetResult = WidgetResult::create([
            'widget_id' => $widget->id,
            'campaign_id' => $campaign->id,
            'widget_type_id' => 1,
            'desktop' => $this->getDesktopResult(),
            'tablet' => $this->getTabletResult(),
            'mobile' => $this->getMobileResult()
        ]);

    }

    private function getDesktopSettings()
    {
        return '{"headline_text":"","articleWidgetText":null,"widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32},"background":{"type":"image","image":{"path":"sidebar-default.jpg","id":0,"type":"image\\\/jpeg","updated_at":"","created_at":"","url":"' . env('ASSETS_URL') . '\/public\/images\/widgets\/landing.jpg"},"color":"#114b7d","opacity":100},"text_margin":[],"text_display":"","text_background":"","common_text":[]},"call_to_action":{"default":{"padding":{"top":"12","right":"0","bottom":"12","left":"0"},"margin":{"top":"10","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Neuton","fontWeight":400,"alignment":"center","color":"#FFFFFF","fontSize":24},"design":{"fill":{"active":true,"color":"#9e0b0f","opacity":100,"selected":true},"border":{"active":false,"color":"#B71100","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":false,"value":"0","selected":true,"tl":"10","tr":"10","br":"10","bl":"10"}},"width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"Medium","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#B71100","opacity":100},"border":{"active":false,"color":"#B71100","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":21},"margin":{"top":"0","right":"0","bottom":"30","left":"0"},"text":"We can write because of your financial support","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"25","right":"55","bottom":"25","left":"55"},"margin":{"top":"40","right":"0","bottom":"5","left":"5"},"width":"532px","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":1,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"Donate 10 \u20ac or more monthly to <b>become a premium member<\/b>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"Donate 100 \u20ac or more to become a premium member","value":100}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":100,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"title"},"cta":{"transfer":{"text":"Go to your bank"},"payBySquare":{"text":"Go to your bank"}}},"third_step":{"title":{"text":"Thank you for your support"},"cta":{"description":"To get all rewards please  fill your personal data in My profile","text":"My profile"}},"terms":{"text":"I agree to processing of personal data and receiving newsletters"}},"email_settings":{"active":false,"subscribe_text":""},"cta":{"text":"Support us","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"688px","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"textContainer":{"width":"50%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"absolute","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"buttonContainer":{"width":"100%","position":"relative","top":"50px","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"35%","display":"inline-block"}}}}';
    }

    private function getTabletSettings()
    {
        return '{"headline_text":"","articleWidgetText":null,"widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32},"background":{"type":"image","image":{"path":"sidebar-default.jpg","id":0,"type":"image\\\/jpeg","updated_at":"","created_at":"","url":"' . env('ASSETS_URL') . '\/backend\/public\/images\/widgets\/landing.jpg"},"color":"#114b7d","opacity":100},"text_margin":[],"text_display":"","text_background":"","common_text":[]},"call_to_action":{"default":{"padding":{"top":"12","right":"0","bottom":"12","left":"0"},"margin":{"top":"10","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Neuton","fontWeight":400,"alignment":"center","color":"#FFFFFF","fontSize":24},"design":{"fill":{"active":true,"color":"#9e0b0f","opacity":100,"selected":true},"border":{"active":false,"color":"#B71100","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":false,"value":"0","selected":true,"tl":"10","tr":"10","br":"10","bl":"10"}},"width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"Medium","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#B71100","opacity":100},"border":{"active":false,"color":"#B71100","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":21},"margin":{"top":"0","right":"0","bottom":"30","left":"0"},"text":"We can write because of your financial support","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"25","right":"55","bottom":"25","left":"55"},"margin":{"top":"40","right":"0","bottom":"5","left":"5"},"width":"532px","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":1,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"Donate 10 \u20ac or more monthly to <b>become a premium member<\/b>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":3,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"Donate 100 \u20ac or more to become a premium member","value":100}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":100,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"title"},"cta":{"transfer":{"text":"Go to your bank"},"payBySquare":{"text":"Go to your bank"}}},"third_step":{"title":{"text":"Thank you for your support"},"cta":{"description":"To get all rewards please  fill your personal data in My profile","text":"My profile"}},"terms":{"text":"I agree to processing of personal data and receiving newsletters"}},"email_settings":{"active":false,"subscribe_text":""},"cta":{"text":"Support us","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"688px","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"textContainer":{"width":"50%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"absolute","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"buttonContainer":{"width":"100%","position":"relative","top":"50px","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"35%","display":"inline-block"}}}}';
    }

    private function getMobileSettings()
    {
        return '{"headline_text":"","articleWidgetText":null,"widget_settings":{"general":{"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":32},"background":{"type":"image","image":{"path":"sidebar-default.jpg","id":0,"type":"image\\\/jpeg","updated_at":"","created_at":"","url":"' . env('ASSETS_URL') . '/public\/images\/widgets\/landing.jpg"},"color":"#114b7d","opacity":100},"text_margin":[],"text_display":"","text_background":"","common_text":[]},"call_to_action":{"default":{"padding":{"top":"12","right":"0","bottom":"12","left":"0"},"margin":{"top":"10","right":"auto","bottom":"0","left":"auto"},"fontSettings":{"fontFamily":"Neuton","fontWeight":400,"alignment":"center","color":"#FFFFFF","fontSize":24},"design":{"fill":{"active":true,"color":"#9e0b0f","opacity":100,"selected":true},"border":{"active":false,"color":"#B71100","size":2,"opacity":0,"selected":true},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0,"selected":true},"radius":{"active":false,"value":"0","selected":true,"tl":"10","tr":"10","br":"10","bl":"10"}},"width":"100%"},"hover":{"type":"fade","fontSettings":{"fontWeight":"Medium","opacity":100,"color":"#FFFFFF"},"design":{"fill":{"active":true,"color":"#B71100","opacity":100},"border":{"active":false,"color":"#B71100","size":2,"opacity":0},"shadow":{"active":false,"color":"#B71100","x":2,"y":2,"b":2,"opacity":0},"radius":{"active":false,"value":"0"}}}},"additional_text":{"text":null,"fontSettings":{"fontFamily":"Roboto Slab","fontWeight":"bold","alignment":"center","color":"#FFFFFF","backgroundColor":"rgba(0,0,0,0)","fontSize":18},"backgroundColor":"rgba(0,0,0,0)","text_margin":{"top":"0","right":"auto","bottom":"0","left":"auto"}}},"payment_settings":{"active":true,"payment_type":"both","type":"classic","monetization_title":{"fontSettings":{"fontFamily":"\"Roboto Slab\", sans-serif","fontWeight":"700","backgroundColor":"#fff","fontSize":21},"margin":{"top":"0","right":"0","bottom":"30","left":"0"},"text":"We can write because of your financial support","textColor":"#1f4e7b","alignment":"center"},"design":{"background_color":"#ffffff","padding":{"top":"24","right":"24","bottom":"24","left":"24"},"margin":{"top":"40","right":"0","bottom":"5","left":"5"},"width":"auto","height":"auto","text_color":"#1f4e7b","shadow":{"color":"#77777","opacity":1,"x":3,"y":3,"b":3}},"monthly_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":2,"options":[{"value":30},{"value":20},{"value":15},{"value":10},{"value":5}],"benefit":{"active":true,"text":"Donate 10 \u20ac or more monthly to <b>become a premium member<\/b>","value":10}},"once_prices":{"custom_price":true,"count_of_options":5,"count_of_options_in_row":2,"options":[{"value":200},{"value":100},{"value":60},{"value":30},{"value":20}],"benefit":{"active":true,"text":"Donate 100 \u20ac or more to become a premium member","value":100}},"default_price":{"monthly_active":true,"monthly_value":20,"one_time_active":true,"one_time_value":100,"styles":{"background":"#3cc300","color":"#ffffff"}},"second_step":{"title":{"text":"title"},"cta":{"transfer":{"text":"Go to your bank"},"payBySquare":{"text":"Go to your bank"}}},"third_step":{"title":{"text":"Thank you for your support"},"cta":{"description":"To get all rewards please  fill your personal data in My profile","text":"My profile"}},"terms":{"text":"I agree to processing of personal data and receiving newsletters"}},"email_settings":{"active":false,"subscribe_text":""},"cta":{"text":"Support us","url":"https:\/\/podpora.postoj.sk"},"additional_settings":{"width":"100%","height":"688px","position":"relative","fixedSettings":[],"display":"block","padding":{"top":"0","right":"0","bottom":"0","left":"0"},"bodyContainer":{"width":"100%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"relative","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"textContainer":{"width":"50%","margin":{"top":"0","right":"auto","bottom":"0","left":"auto"},"position":"absolute","top":"80px","right":"auto","bottom":"auto","left":"auto","text":{"width":"100%"}},"buttonContainer":{"width":"100%","position":"relative","top":"50px","right":"auto","bottom":"auto","left":"auto","textAlign":"center","button":{"width":"35%","display":"inline-block"}}}}';
    }

    private function getDesktopResult()
    {
        return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-landing" style="position: relative; height: 100%; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(17, 75, 125); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: absolute; width: 100%; margin: 0px auto; color: rgb(255, 255, 255); background-color: rgb(17, 75, 125);"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="font-size: 32px; color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: auto;"></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" style="display: flex" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="desktop"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="color: rgb(119, 119, 119); width: 30%; height: auto; background-color: rgb(255, 255, 255); margin: 35px 5px 5px 35px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(119, 119, 119); width: 100%; text-align: center; position: relative; height: auto;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Step 1 of 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 0px 30px 15px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "We can write because of <br> y"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;">We can write because of <br> your financial support!</h1></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price" placeholder="custom" type="number" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price" placeholder="custom" type="number" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px;">Donate 20 € or more monthly to become a premium member</div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px;"><span>Donate 100 € or more to become a premium member</span></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Your email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;">I agree to processing of personal data and receiving newsletters</label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Please agree with terms and conditions</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">Support us</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">One-time payment</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Monthly donation</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "Please choose payment option"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;">Please choose payment option</h1></div><div _ngcontent-c27="" class="payment-options cft--monatization--hidden"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" for="cr0wdWidgetContent-landing-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" id="cr0wdWidgetContent-landing-transfer"><div _ngcontent-c27="">Bank transfer</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" for="cr0wdWidgetContent-landing-bayBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" id="cr0wdWidgetContent-landing-bayBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Amount</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">Redirect to your bank</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">Done</div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "Thank you for your support"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;">Thank you for your support</h1></div><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Amount</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center"> To get all rewards please  fill your personal data in My profile </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">My profile</a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 15px; top: 15px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(255, 255, 255);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #0087ed;
                    border-color: #32a300;
                }
        
            .cft--monatization--membership-checkbox.active:before{
                    background-color: #0087ed;
                    border: 1px solid #ffffff
                }
            .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            .cft--monatization--hidden{
                display: none!important
             }
            </style><style class="globalStyles" type="text/css">
    <style>
    body {height: 100%; background: #FFFFFF;}
    div {
    box-sizing: border-box;
    }
    .content {width: 100%;}
    
    .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
    .cft--monatization--membership-checkbox:before {
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
    
    .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
    .cft--monatization--membership-checkbox.active:after{
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

    .cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    .cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
    .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
    .submitted input:invalid ~ label.error {
        display: none;
    }    
    .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
    .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
     }
    .cft--monetization--container-step-2 select {
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
    .cft--monetization--container-step-2 .bank-button__select:before{
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
    .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
    }
    .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    .cft--monetization--container .head{
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
        
    .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
</style>
</style><style class="hoverStyles" type="text/css">
            .cft__cta__button:hover{
                
            color:#ffffff!important;
            font-weight:400!important;
           
            background-color:#9e0b0f!important;
            opacity:1!important;
            
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 20
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
    console.log(landingDocument, landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\'), chosenButton.getElementsByTagName(\'input\')[0].value, target);
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
    let target = 100
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
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var form = landingDocument.getElementById(\'cft--monatization--form--donate\').className += \' submitted\';
    validInput = landingDocument.getElementById(\'cft--monatization--form--donate--email\').checkValidity()
        && landingDocument.getElementById(\'cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
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
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
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
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.user_token, xhr_1.response.donation_id);
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
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\').innerHTML = bankAccount;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\').innerHTML = variableSymbol;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\').innerHTML = value + \' € \' + frequency;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\').innerHTML = bankAccount;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\').innerHTML = variableSymbol;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\').innerHTML = value + \' € \' + frequency;
    var paymentOptions = monetizationEl.querySelector(\'.payment-options\');
    if (frequency === \'one-time\') {
        paymentOptions.className = paymentOptions.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    else {
        paymentOptions.className += \' cft--monatization--hidden\';
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
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\">\n                        </div> \n                  </div>");
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
    var data = JSON.stringify({
        \'donation_id\': element.closest(\'.cft--monetization--container\').dataset.donationId,
        \'payment_method_id\': element.closest(\'.payment-option\').dataset.id
    });
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            showThirdPage(element, xhr.response);
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
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/ cft--monatization--hidden/g, \'\');
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
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 2 of 3\';
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 1 of 3\';
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 3 of 3\';
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 2 of 3\';
    }
}
function showThirdPage(element, response) {
    step(element, true);
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
    }

    private function getTabletResult()
    {
        return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-landing" style="position: relative; height: 100%; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(17, 75, 125); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: absolute; width: 100%; margin: 0px auto; color: rgb(255, 255, 255); background-color: rgb(17, 75, 125);"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="font-size: 32px; color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: auto;"></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" style="display: flex" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="tablet"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="color: rgb(119, 119, 119); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 25px 85px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(119, 119, 119); width: 100%; text-align: center; position: relative; height: auto;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Step 1 of 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px 80px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<span style=\"font-family: Lato"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><span>We can write because of&nbsp;</span><br><span>your financial support!</span></h1></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price" placeholder="custom" type="number" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price" placeholder="custom" type="number" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px;"><span>Donate 20 € or more monthly to become a premium member</span></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px;"><span>Donate 100 € or more to become a premium member</span></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Your email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;">I agree to processing of personal data and receiving newsletters</label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Please agree with terms and conditions</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px 0px 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">Support us</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">One-time payment</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Monthly donation</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "<span style=\"font-family: Lato"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><span>Please choose payment option</span></h1></div><div _ngcontent-c27="" class="payment-options cft--monatization--hidden"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" for="cr0wdWidgetContent-landing-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" id="cr0wdWidgetContent-landing-transfer"><div _ngcontent-c27="">Bank transfer</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" for="cr0wdWidgetContent-landing-bayBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" id="cr0wdWidgetContent-landing-bayBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Amount</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px 0px 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;"><span>Redirect to your bank</span><br></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px 0px 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;"><span>Done</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "Thank you for your support"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;">Thank you for your support</h1></div><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Amount</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center"> To get all rewards please  fill your personal data in My profile </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px 0px 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 12px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">My profile</a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 15px; top: 15px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(255, 255, 255);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #0087ed;
                    border-color: #32a300;
                }
        
            .cft--monatization--membership-checkbox.active:before{
                    background-color: #0087ed;
                    border: 1px solid #ffffff
                }
            .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            .cft--monatization--hidden{
                display: none!important
             }
            </style><style class="globalStyles" type="text/css">
    <style>
    body {height: 100%; background: #FFFFFF;}
    div {
    box-sizing: border-box;
    }
    .content {width: 100%;}
    
    .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
    .cft--monatization--membership-checkbox:before {
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
    
    .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
    .cft--monatization--membership-checkbox.active:after{
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

    .cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    .cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
    .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
    .submitted input:invalid ~ label.error {
        display: none;
    }    
    .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
    .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
     }
    .cft--monetization--container-step-2 select {
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
    .cft--monetization--container-step-2 .bank-button__select:before{
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
    .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
    }
    .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    .cft--monetization--container .head{
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
        
    .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
</style>
</style><style class="hoverStyles" type="text/css">
            .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:100!important;
           
            background-color:#9e0b0f!important;
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
    console.log(landingDocument, landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\'), chosenButton.getElementsByTagName(\'input\')[0].value, target);
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
    let target = 10
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
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var form = landingDocument.getElementById(\'cft--monatization--form--donate\').className += \' submitted\';
    validInput = landingDocument.getElementById(\'cft--monatization--form--donate--email\').checkValidity()
        && landingDocument.getElementById(\'cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
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
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
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
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.user_token, xhr_1.response.donation_id);
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
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\').innerHTML = bankAccount;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\').innerHTML = variableSymbol;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\').innerHTML = value + \' € \' + frequency;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\').innerHTML = bankAccount;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\').innerHTML = variableSymbol;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\').innerHTML = value + \' € \' + frequency;
    var paymentOptions = monetizationEl.querySelector(\'.payment-options\');
    if (frequency === \'one-time\') {
        paymentOptions.className = paymentOptions.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    else {
        paymentOptions.className += \' cft--monatization--hidden\';
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
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\">\n                        </div> \n                  </div>");
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
    var data = JSON.stringify({
        \'donation_id\': element.closest(\'.cft--monetization--container\').dataset.donationId,
        \'payment_method_id\': element.closest(\'.payment-option\').dataset.id
    });
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            showThirdPage(element, xhr.response);
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
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/ cft--monatization--hidden/g, \'\');
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
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 2 of 3\';
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 1 of 3\';
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 3 of 3\';
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 2 of 3\';
    }
}
function showThirdPage(element, response) {
    step(element, true);
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
    }

    private function getMobileResult()
    {
        return '<link _ngcontent-c14="" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Roboto Slab"><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none; width: 100%; height: 100%; top: -140px; position: absolute; z-index: 9999; background: rgba(0, 0, 0, 0.7);"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--background" ng-reflect-ng-style="[object Object]" id="cr0wdWidgetContent-landing" style="position: relative; height: 100%; width: 100%; max-width: 100%; left: 0px; margin: 0px auto; background-repeat: no-repeat; background-size: cover; padding: 0px;"><div _ngcontent-c14="" class="cft--overlay" ng-reflect-ng-style="[object Object]" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(17, 75, 125); opacity: 1;"></div><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c14="" class="cft--body" ng-reflect-ng-style="[object Object]" style="position: absolute; width: 100%; margin: 0px auto; color: rgb(255, 255, 255); background-color: rgb(17, 75, 125);"><div _ngcontent-c14="" class="cft--text-container" ng-reflect-ng-style="[object Object]"><div _ngcontent-c14="" class="cft--headline-text" ng-reflect-ng-style="[object Object]" style="font-size: 32px; color: rgb(255, 255, 255); font-family: &quot;Roboto Slab&quot;; width: 100%; margin: auto;"></div><div _ngcontent-c14="" class="cft--additional-text" ng-reflect-ng-style="[object Object]" style="text-align: center; font-size: 18px; font-family: &quot;Roboto Slab&quot;; width: 100%; display: block; margin: 0px auto; color: rgb(255, 255, 255);"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><app-preview-monetization _ngcontent-c14="" class="preview-monetization" style="display: flex" _nghost-c27="" ng-reflect-widget="[object Object]" ng-reflect-device-type="mobile"><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monetization--container" id="cft-monetization__container" ng-reflect-ng-style="[object Object]" style="color: rgb(119, 119, 119); width: 100%; height: auto; background-color: rgb(255, 255, 255); margin: 15px;"><div _ngcontent-c27="" class="head" ng-reflect-ng-style="[object Object]" style="color: rgb(119, 119, 119); width: 100%; text-align: center; position: relative; height: auto;"><span _ngcontent-c27="" class="step-back cft--monatization--hidden" onclick="parent.step(this, false)"></span><span _ngcontent-c27="" class="title">Step 1 of 3</span></div><div _ngcontent-c27="" class="body" ng-reflect-ng-style="[object Object]" style="padding: 5px 15px;"><div _ngcontent-c27="" class="cft--monetization--container-step-1"><!--bindings={
  "ng-reflect-ng-if": "<span style=\"font-family: Lato"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><span>We can write because of&nbsp;</span><br><span>your financial support!</span></h1></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly active" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="15"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 15 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="10"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 10 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="5"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 5 </div><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--monthly" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonMonthly(this, true)" oninput="parent.setActiveButtonMonthly(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price" placeholder="custom" type="number" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"><div _ngcontent-c27="" class="cft--monatization--donation-button-periodicity" ng-reflect-ng-style="[object Object]" style="font-size: 14px; text-align: center;"> monthly </div></div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-wrapper cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;"><!--bindings={
  "ng-reflect-ng-for-of": "[object Object],[object Object"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="200"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 200 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time active" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="100"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 100 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="60"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 60 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="30"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 30 </div></div></div><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" id="cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" type="hidden" value="20"><div _ngcontent-c27="" class="cft--monatization--donation-button-price" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center;"> 20 </div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--donation-button-container cft--monatization--donation-button--one-time" ng-reflect-klass="cft--monatization--donation-bu" ng-reflect-ng-class="[object Object]" ng-reflect-ng-style="[object Object]" style="flex: 0 0 33.3333%; max-width: 33.3333%; padding: 6px 15px; width: 100%; min-height: 1px; box-sizing: border-box; display: flex; flex-direction: column;"><div _ngcontent-c27="" class="cft--monatization--donation-button" onclick="parent.setActiveButtonOneTime(this, true)" oninput="parent.setActiveButtonOneTime(this)" ng-reflect-ng-style="[object Object]" style="min-height: 40px; padding: 5px; border: 1px solid rgb(189, 194, 198); border-radius: 2px; box-shadow: rgba(91, 107, 120, 0.2) 0px 1px 2px 0px; flex: 1 1 0%; display: flex; flex-direction: column; justify-content: center; cursor: pointer;"><input _ngcontent-c27="" class="cft--monatization--donation-input-price" placeholder="custom" type="number" ng-reflect-ng-style="[object Object]" style="font-size: 18px; font-weight: 700; line-height: 1; padding: 1px 0px; text-align: center; outline: none; border: none; background: transparent; width: 100%; color: inherit;"></div></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-monthly"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--monthly" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px;"><span>Donate 20 € or more monthly to become a premium member</span></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--membership cft--monatization--only-one-time cft--monatization--hidden"><span _ngcontent-c27="" class="cft--monatization--membership-checkbox active" id="cft--monatization--membership-checkbox--one-time" ng-reflect-klass="cft--monatization--membership-" ng-reflect-ng-class="[object Object]"></span><div _ngcontent-c27="" class="cft--monatization--membership-membership-text" ng-reflect-ng-style="[object Object]" style="padding-left: 50px; margin: 12px 0px;"><span>Donate 100 € or more to become a premium member</span></div></div><form _ngcontent-c27="" class="form ng-untouched ng-pristine ng-valid" id="cft--monatization--form--donate" method="post" novalidate="" onsubmit="parent.handleSubmit(this, event)"><div _ngcontent-c27="" class="cft--monatization--form-group--donate" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><label _ngcontent-c27="" class="label" for="cft--monatization--form--donate--email" ng-reflect-ng-style="[object Object]" style="width: 100%; display: block; color: inherit; text-align: left; font-size: 100%;">Your email</label><input _ngcontent-c27="" class="cft--monatization--form--donate--email" id="cft--monatization--form--donate--email" name="email" onchange="parent.trackEmailOnChange(this)" required="" type="email" ng-reflect-ng-style="[object Object]" style="color: inherit; padding: 6px; width: 100%;"><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--email" id="cft--monatization--form-email-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">E-mail has wrong format</label></div><div _ngcontent-c27="" class="cft--monatization--form--donate--terms" ng-reflect-ng-style="[object Object]" style="padding-top: 16px;"><input _ngcontent-c27="" id="cft--monatization--form--donate--terms" name="terms_agreed" required="" type="checkbox" value="0"><label _ngcontent-c27="" for="cft--monatization--form--donate--terms" style="display: inline; padding-left: 6px;">I agree to processing of personal data and receiving newsletters</label><label _ngcontent-c27="" class="error" for="cft--monatization--form--donate--terms" id="cft--monatization--form--donate--terms-error" ng-reflect-ng-style="[object Object]" style="display: none; font-size: 14px; color: red; margin-top: 3px;">Please agree with terms and conditions</label></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><button _ngcontent-c27="" class="cft__cta__button" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;">Support us</button></div></form><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-monthly" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.oneTimePayment()">One-time payment</a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--monatization--additional-links cft--monatization--only-one-time cft--monatization--hidden" ng-reflect-ng-style="[object Object]" style="text-align: center; padding: 16px;"><a _ngcontent-c27="" href="javascript:void(0)" onclick="parent.monthlyPayment()">Monthly donation</a></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-2  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "<span style=\"font-family: Lato"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><span>Please choose payment option</span></h1></div><div _ngcontent-c27="" class="payment-options cft--monatization--hidden"><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" for="cr0wdWidgetContent-landing-transfer"><input _ngcontent-c27="" checked="" name="payment-option" type="radio" value="1" id="cr0wdWidgetContent-landing-transfer"><div _ngcontent-c27="">Bank transfer</div></label><label _ngcontent-c27="" class="payment-options__button" onclick="parent.changePaymentOptions(this)" for="cr0wdWidgetContent-landing-bayBySquare"><input _ngcontent-c27="" name="payment-option" type="radio" value="3" id="cr0wdWidgetContent-landing-bayBySquare"><div _ngcontent-c27="">Pay by square</div></label></div><div _ngcontent-c27="" class="payment-option" data-id="1"><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Amount</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><div _ngcontent-c27="" class="bank-button__wrapper"></div></div><div _ngcontent-c27="" class="qr__wrapper payment-option cft--monatization--hidden" data-id="3"><div _ngcontent-c27="" class="pay-by-square__wrapper"></div></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" data-id="1" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;"><span>Redirect to your bank</span></a></div><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option cft--monatization--hidden" data-id="3" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><div _ngcontent-c27="" class="cft__cta__button cft--button--redirect" href="http://google.com" onclick="parent.donationInProgress(this)" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;"><span>Done</span></div></div></div><div _ngcontent-c27="" class="cft--monetization--container-step-3  cft--monatization--hidden"><!--bindings={
  "ng-reflect-ng-if": "<span style=\"font-family: Lato"
}--><div _ngcontent-c27="" class="cft--monatization--title" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><h1 _ngcontent-c27="" ng-reflect-ng-style="[object Object]" style="color: rgb(17, 75, 125); text-align: center;"><span>Thank you for your support</span></h1></div><table _ngcontent-c27="" border="0" cellpadding="0" cellspacing="0" class="payment-table"><tbody _ngcontent-c27=""><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">IBAN</td><td _ngcontent-c27="" class="payment-value payment-iban"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Var. symbol</td><td _ngcontent-c27="" class="payment-value payment-vs"></td></tr><tr _ngcontent-c27=""><td _ngcontent-c27="" class="payment-title">Amount</td><td _ngcontent-c27="" class="payment-value"><span _ngcontent-c27="" class="payment-amount"></span></td></tr></tbody></table><h4 _ngcontent-c27="" style="text-align: center"> &lt;span style="font-family: Lato, sans-serif;"&gt;To get all rewards please fill your personal data in My profile&lt;/span&gt; </h4><!--bindings={
  "ng-reflect-ng-if": "true"
}--><div _ngcontent-c27="" class="cft--button-container payment-option" ng-reflect-ng-style="[object Object]" style="text-align: center; margin: 10px auto 0px;"><a _ngcontent-c27="" class="cft__cta__button cft--button--redirect cft__redirect-to-my-account" target="_blank" type="submit" ng-reflect-ng-style="[object Object]" style="width: 100%; padding: 8px 15px; font-family: &quot;Roboto Slab&quot;; font-weight: 400; text-align: center; color: rgb(255, 255, 255); font-size: 20px; background-color: rgb(237, 28, 36); border: none; box-shadow: none; border-radius: 0px; cursor: pointer; text-decoration: none; transition: all 0.5s ease 0s; display: inline-block;"><span>My profile</span></a></div></div></div></div></app-preview-monetization><!--bindings={
  "ng-reflect-ng-if": "false"
}--><!--bindings={
  "ng-reflect-ng-if": "false"
}--></div><span _ngcontent-c14="" class="cr0wdWidgetContent--closeWidget" ng-reflect-ng-style="[object Object]" style="position: absolute; right: 15px; top: 15px; width: 20px; height: 20px; cursor: pointer; display: none;"><svg _ngcontent-c14="" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g _ngcontent-c14="" id="close" transform="translate(-1850 -23)"><rect _ngcontent-c14="" fill="transparent" height="24" id="safearea" opacity="0" transform="translate(1850 23)" width="24"></rect><g _ngcontent-c14="" id="icon" transform="translate(5 5)"><path _ngcontent-c14="" d="M13.747,12.712,8.03,6.95,13.747,1.1a.653.653,0,0,0,0-.945.653.653,0,0,0-.945,0L7.085,5.96,1.1.2A.591.591,0,0,0,.153.2a.685.685,0,0,0,0,.9L6.095,6.9.153,12.712a.653.653,0,0,0,0,.945.677.677,0,0,0,.5.18.677.677,0,0,0,.5-.18L7.085,7.85,12.8,13.657a.677.677,0,0,0,.5.18.522.522,0,0,0,.45-.18A.652.652,0,0,0,13.747,12.712Z" data-name="Path 31" id="Path_31" transform="translate(1850.05 23.05)" ng-reflect-ng-style="[object Object]" style="fill: rgb(255, 255, 255);"></path></g></g></svg></span></div><div _ngcontent-c14="" ng-reflect-ng-style="[object Object]" style="display: none;"></div><div _ngcontent-c14="" id="styles"><style class="monetizationStyles" type="text/css">
            .active > .cft--monatization--donation-button{
                    color: #ffffff;
                    background-color: #0087ed;
                    border-color: #32a300;
                }
        
            .cft--monatization--membership-checkbox.active:before{
                    background-color: #0087ed;
                    border: 1px solid #ffffff
                }
            .cft--monatization--membership-checkbox.active:after{
                    border: solid #ffffff;
                    border-width: 0 2px 2px 0;
                }
                
            .cft--monatization--hidden{
                display: none!important
             }
            </style><style class="globalStyles" type="text/css">
    <style>
    body {height: 100%; background: #FFFFFF;}
    div {
    box-sizing: border-box;
    }
    .content {width: 100%;}
    
    .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
    .cft--monatization--membership-checkbox:before {
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
    
    .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
    .cft--monatization--membership-checkbox.active:after{
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

    .cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    .cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
    .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
    .submitted input:invalid ~ label.error {
        display: none;
    }    
    .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
    .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
     }
    .cft--monetization--container-step-2 select {
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
    .cft--monetization--container-step-2 .bank-button__select:before{
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
    .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
    }
    .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    .cft--monetization--container .head{
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
        
    .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .step-back:before{
        content: \'\25C0\';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
</style>
</style><style class="hoverStyles" type="text/css">
            .cft__cta__button:hover{
                
            color:#FFFFFF!important;
            font-weight:100!important;
           
            background-color:#B71100!important;
            opacity:1!important;
            
             }
            </style></div><div _ngcontent-c14="" id="scripts"><script type="text/javascript" charset="utf-8" class="previewScripts">function setActiveButtonMonthly(chosenButton, focusInput, track) {
    if (track === void 0) { track = true; }
    var apiPublicUrl = getEnvs().apiPublicUrl + \'/portal/\'; // TEST API
    let target = 20
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
    console.log(landingDocument, landingDocument.getElementById(\'cft--monatization--membership-checkbox--monthly\'), chosenButton.getElementsByTagName(\'input\')[0].value, target);
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
    let target = 100
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
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
    }
    var form = landingDocument.getElementById(\'cft--monatization--form--donate\').className += \' submitted\';
    validInput = landingDocument.getElementById(\'cft--monatization--form--donate--email\').checkValidity()
        && landingDocument.getElementById(\'cft--monatization--form--donate--terms\').checkValidity();
    return validInput;
}
function oneTimePayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
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
}
function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById(\'crowdWidgetContent-preview\')) {
        var iframe = document.getElementById(\'crowdWidgetContent-preview\');
        landingDocument = iframe.contentWindow.document;
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
            \'show_id\': el.closest(\'[id^=cr0wdfundingToolbox]\').dataset.showId,
            \'email\': el.querySelector(\'#cft--monatization--form--donate--email\').value,
            \'email_valid\': el.querySelector(\'#cft--monatization--form--donate--email\').checkValidity(),
            \'terms\': el.querySelector(\'#cft--monatization--form--donate--terms\').checked,
            \'frequency\': frequency,
            \'amount\': selectedValue
        });
        var xhr_1 = new XMLHttpRequest();
        xhr_1.onload = function () {
            if (xhr_1.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr_1.response.variable_symbol, xhr_1.response.bank_account, xhr_1.response.bankButtons, selectedValue, frequency, xhr_1.response.qrCode, xhr_1.response.user_token, xhr_1.response.donation_id);
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
function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency, payBySquareBlob, userToken, donationId) {
    monetizationEl.dataset.donationId = donationId;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-iban\').innerHTML = bankAccount;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-vs\').innerHTML = variableSymbol;
    monetizationEl.querySelector(\'.cft--monetization--container-step-2 .payment-amount\').innerHTML = value + \' € \' + frequency;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-iban\').innerHTML = bankAccount;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-vs\').innerHTML = variableSymbol;
    monetizationEl.querySelector(\'.cft--monetization--container-step-3 .payment-amount\').innerHTML = value + \' € \' + frequency;
    var paymentOptions = monetizationEl.querySelector(\'.payment-options\');
    if (frequency === \'one-time\') {
        paymentOptions.className = paymentOptions.className.replace(/ cft--monatization--hidden/g, \'\');
    }
    else {
        paymentOptions.className += \' cft--monatization--hidden\';
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
            bankButtonsWrapper.insertAdjacentHTML(\'beforeEnd\', "<div class=\"bank-button__container\"> \n                        <div class=\"bank-button\" data-bank-link=\"" + bankButtonsData[i].redirect_link + "\" onclick=\"parent.setBankButton(this)\">\n                            <img src=\"" + bankButtonsData[i].image.url + "\" alt=\"" + bankButtonsData[i].title + "\">\n                        </div> \n                  </div>");
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
    var data = JSON.stringify({
        \'donation_id\': element.closest(\'.cft--monetization--container\').dataset.donationId,
        \'payment_method_id\': element.closest(\'.payment-option\').dataset.id
    });
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            showThirdPage(element, xhr.response);
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
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/ cft--monatization--hidden/g, \'\');
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
    // move from step 1 to step 2
    if (firstStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 2 of 3\';
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, \'\');
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 1 of 3\';
        stepBack.className = \'step-back cft--monatization--hidden\';
    }
    else 
    // move from step 2 to step 3
    if (secondStep.className.indexOf(\'cft--monatization--hidden\') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + \' cft--monatization--hidden\';
        thirdStep.className = thirdStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 3 of 3\';
        stepBack.className = \'step-back\';
    }
    else 
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf(\'cft--monatization--hidden\') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + \' cft--monatization--hidden\';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, \'\');
        // update header
        monetizationCont.querySelector(\'.head .title\').innerHTML = \'Step 2 of 3\';
    }
}
function showThirdPage(element, response) {
    step(element, true);
}
function getEnvs() {
    return {
        apiPublicUrl: \'http://localhost:8001/api\'
    };
}
</script></div>';
    }

    private function changeMonthlySupport($previousUserDonation, float $probabilityToChangeDonation)
    {
        $probabilityPercent = $probabilityToChangeDonation * 100;
        $random = rand(0, 100);
        return $random < $probabilityPercent ? $this->getRandomDonation() : $previousUserDonation;
    }

    private function setImagesToCampaigns()
    {
        $campaigns = Campaign::with('widget')->get();
        foreach ($campaigns as $c) {
            if (sizeof($c->widget) > 1) { // if is not Landing Dummy Campaign
                foreach ($c->widget as $w) {
                    if ($w->widget_type_id == 2) { // sidebar
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 1
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 2
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 3
                        ]);
                    }

                    if ($w->widget_type_id == 2) { // leaderboard
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 3,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 1
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 3,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 2
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 3,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 3
                        ]);
                    }

                    if ($w->widget_type_id == 6) { // locked
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 1
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 2
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 3
                        ]);
                    }
                    if ($w->widget_type_id == 1) { // landing
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 4,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 1
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 4,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 2
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 4,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 3
                        ]);
                    }

                }

            } else {
                foreach ($c->widget as $w) {
                    if ($w->widget_type_id == 1) { // landing
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 4,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 1
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 4,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 2
                        ]);
                        \Modules\Campaigns\Entities\CampaignImage::create([
                            'campaign_id' => $c->id,
                            'image_id' => 4,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'widget_id' => $w->id,
                            'device_type' => 3
                        ]);
                    }
                }
            }
        }
    }

    private function getRandomDonation()
    {
        return rand(1, 6) * 5;
    }

    private function createPayment($donation_id, $portal_user_id, $amount, $transaction_date)
    {
        if ($portal_user_id !== null) {
            $variable_symbol = PortalUser::where('id', $portal_user_id)
                ->with('variableSymbol')
                ->first()->variableSymbol['variable_symbol'];
        } else {
            $variable_symbol = 2019; // case for bad variable symbol
        }

        $request = array(
            'transaction_id' => $this->transactionId(10),
            'variable_symbol' => $variable_symbol,
            'iban' => $this->iban(16),
            'amount' => $amount,
            'transfer_type' => $this->paymentMethod(),
            'created_by' => $this->createdBy(),
            'transaction_date' => $transaction_date
        );
        $payment = $this->paymentService->createPayment($request);
        return $payment;
    }

    private function transactionId($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function iban($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = 'SK';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function paymentMethod()
    {
        $methods = $this->paymentMehhodService->all();
        return $methods[array_rand(json_decode($methods))]->id;
    }

    private function createdBy()
    {
        // randomly return one of next values
        $createdByArr = ['API', 'parsing', 'import'];
        return $createdByArr[array_rand($createdByArr)];
    }


    // TRACKING SEEDER (Flow -- trackingVisit -- trackingShow -- donations -- payments)
    private function generateTrackingAndPayments($portalUserId, $userCreatedAt)
    {
        // generate 30 tracking records for each portal user
        $trackingSites = array();
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/74/ked-george-soros-a-charles-koch-financuju-katolickeho-konzervativca',
            'article_id' => 74,
            'author' => 'Ferko Mrkvicka',
            'title' => 'Keď George Soros a Charles Koch financujú katolíckeho konzervatívca'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/73/klerofasisticke-pokusenie-ladislava-hanusa',
            'article_id' => 73,
            'author' => 'John Doe',
            'title' => 'Klérofašistické pokušenie Ladislava Hanusa'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/69/najvaecsia-reforma-smeru-v-zdravotnictve-za-dvanast-rokov-projekty-penty',
            'article_id' => 69,
            'author' => 'Peter Balbercak',
            'title' => 'Najväčšia reforma Smeru v zdravotníctve za dvanásť rokov? Projekty Penty'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/72/v-centre-bratislavy-vylupili-zlatnictvo-ukradli-sperky-za-viac-ako-50-tisic-eur',
            'article_id' => 72,
            'author' => 'Donald Trump',
            'title' => 'V centre Bratislavy vylúpili zlatníctvo, ukradli šperky za viac ako 50-tisíc eur'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/70/o-lobotku-udajne-prejavil-zaujem-ac-milano',
            'article_id' => 70,
            'author' => 'Bill Cosby',
            'title' => 'O Lobotku údajne prejavil záujem AC Miláno'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news/68/zelensky-hovoril-s-putinom-aj-o-zajatych-ukrajinskych-namornikoch',
            'article_id' => 68,
            'author' => 'George Bush',
            'title' => 'Zelenský hovoril s Putinom aj o zajatých ukrajinských námorníkoch'
        ));
        array_push($trackingSites, array(
            'url' => 'https://www.demo-postoj.crowdfundingtoolbox.news',
            'article_id' => null,
            'title' => ''
        ));

        $articles = json_decode(\Modules\Campaigns\Entities\Article::all());

        for ($i = 0; $i < 5; $i++) {
            $tracking = $trackingSites[array_rand($trackingSites)];
            $donationDate = Carbon::now()->setHour(rand(8, 23))->setMinute(rand(0, 59))->setSecond(rand(0, 59))->subDays(rand(0, 150));

            // for case when donation would be older than user registration date
            if (Carbon::createFromFormat('Y-m-d H:i:s', $userCreatedAt) > $donationDate) {
                $donationDate = Carbon::createFromFormat('Y-m-d H:i:s', $userCreatedAt)->addMinutes(rand(1, 360));
            }

            if ($tracking['article_id'] == null) {
                $trackingVisit = TrackingVisit::create([
                    'portal_user_id' => $portalUserId,
                    'user_cookie' => null,
                    'url' => $tracking['url'],
                    'article_id' => null,
                    'created_at' => $donationDate
                ]);
            } else {

                $trackingVisit = TrackingVisit::create([
                    'portal_user_id' => $portalUserId,
                    'user_cookie' => null,
                    'url' => $tracking['url'],
                    'article_id' => $articles[array_rand($articles)]->id,
                    'created_at' => $donationDate
                ]);
            }

            $widget = Widget::inRandomOrder()->first();
            $trackingShow = TrackingShow::create([
                'tracking_visit_id' => $trackingVisit->id,
                'widget_id' => $widget->id,
                'created_at' => $donationDate
            ]);
            if ($widget->widget_type_id === 1) {
                $widgetReferral = Widget::inRandomOrder()->first();
                $amountInitialized = abs(rand(1.5, 50.4));
                $paymentMethods = [1, 2, 3, 4, 5];
                $donationStatuses = ['waiting_for_payment', 'initialized', 'waiting_for_payment']; // 2:1
                $donation = Donation::create([
                    'portal_user_id' => $portalUserId,
                    'widget_id' => $widget->id,
                    'referral_widget_id' => ($widgetReferral->widget_type_id !== 1) ? $widgetReferral->id : null,
                    'amount' => rand(1, 50),
                    'amount_initialized' => $amountInitialized,
                    'is_monthly_donation' => (bool)random_int(0, 1),
                    'created_at' => $donationDate,
                    'updated_at' => $donationDate,
                    'tracking_show_id' => $trackingShow->id,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'status' => $donationStatuses[array_rand($donationStatuses)]
                ]);
                if ($i % 7 !== 0) {
                    $payment = $this->createPayment($donation->id, $portalUserId, $donation->amount, $donation->created_at);
                    if ($portalUserId !== null) {
                        Donation::where('id', $donation->id)->update(array(
                            'status' => 'processed',
                            'payment_id' => $payment->id
                        ));
                        $userPaymentOption = \Modules\UserManagement\Entities\UserPaymentOption::where('portal_user_id', $portalUserId)->first();
                        if ($userPaymentOption->bank_account_number === null) {
                            \Modules\UserManagement\Entities\UserPaymentOption::where('portal_user_id', $portalUserId)->update([
                                'bank_account_number' => $this->generateIban()
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function generateIban()
    {
        $bankPrefixes = ['1100', '1111', '0900', '0200', '7500', '0720', '3000', '3100', '5200', '5800', '5900', '6500'];
        $bankSecondIdentificators = ['0000', '5432', '5555', '1234', '0123', '0000', '0000'];
        $set = '0123456789';
        $rand = substr(str_shuffle($set), 0, 10);

        return 'SK' . $bankPrefixes[array_rand($bankPrefixes)] .
            $bankSecondIdentificators[array_rand($bankSecondIdentificators)] . '0000' . $rand;
    }

}
