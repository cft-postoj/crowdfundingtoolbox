<?php

namespace Modules\Campaigns\Services;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignImage;
use Modules\Campaigns\Entities\CampaignsConfiguration;
use Modules\Campaigns\Entities\CampaignsVisited;
use Modules\Campaigns\Entities\DeviceType;
use Modules\Campaigns\Entities\UserData;
use Modules\Campaigns\Entities\UserDonationData;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Campaigns\Entities\WidgetVersion;
use Modules\Campaigns\Http\Controllers\WidgetTypesController;
use Modules\Campaigns\Repositories\CampaignRepository;
use Modules\Campaigns\Transformers\WidgetResource;
use Modules\Campaigns\Transformers\WidgetResultResource;
use Modules\Campaigns\WidgetTypesResources\ArticleWidget;
use Modules\Campaigns\WidgetTypesResources\FixedWidget;
use Modules\Campaigns\WidgetTypesResources\LeaderboardWidget;
use Modules\Campaigns\WidgetTypesResources\LockedArticleWidget;
use Modules\Campaigns\WidgetTypesResources\PopupWidget;
use Modules\Campaigns\WidgetTypesResources\SidebarWidget;
use Modules\Payment\Services\ComfortPayService;
use Modules\Payment\Services\DonationService;
use Modules\Payment\Services\PaymentService;
use Modules\Targeting\Entities\Targeting;
use Modules\UserManagement\Emails\DonationEmail;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\TrackingCampaignShowService;
use Modules\UserManagement\Services\TrackingService;
use Modules\UserManagement\Services\UserDetailService;
use Modules\UserManagement\Services\UserService;
use Tymon\JWTAuth\Facades\JWTAuth;

class WidgetService implements WidgetServiceInterface
{


    private $widgetSettings;
    private $paymentSettings;
    private $trackingService;
    private $userService;
    private $sidebarWidget;
    private $fixedWidget;
    private $popupWidget;
    private $leaderboardWidget;
    private $lockedArticleWidget;
    private $articleWidget;
    private $articleService;
    private $portalUserService;
    private $campaignRepository;
    private $paymentService;
    private $donationService;
    private $trackingCampaignShowS;
    private $userDetailService;

    const FIXED_WIDGET_TYPE_ID = 5;
    const POPUP_WIDGET_TYPE_ID = 4;

    public function __construct(TrackingService $trackingService,
                                UserService $userService,
                                SidebarWidget $sidebarWidget,
                                FixedWidget $fixedWidget,
                                PopupWidget $popupWidget,
                                LeaderboardWidget $leaderboardWidget,
                                LockedArticleWidget $lockedArticleWidget,
                                ArticleWidget $articleWidget,
                                ArticleService $articleService,
                                PortalUserService $portalUserService,
                                CampaignRepository $campaignRepository,
                                PaymentService $paymentService,
                                DonationService $donationService,
                                TrackingCampaignShowService $trackingCampaignShowService,
                                UserDetailService $userDetailService)
    {
        $this->trackingService = $trackingService;
        $this->userService = $userService;
        $this->sidebarWidget = $sidebarWidget;
        $this->fixedWidget = $fixedWidget;
        $this->popupWidget = $popupWidget;
        $this->leaderboardWidget = $leaderboardWidget;
        $this->lockedArticleWidget = $lockedArticleWidget;
        $this->articleWidget = $articleWidget;
        $this->articleService = $articleService;
        $this->portalUserService = $portalUserService;
        $this->campaignRepository = $campaignRepository;
        $this->paymentService = $paymentService;
        $this->donationService = $donationService;
        $this->trackingCampaignShowS = $trackingCampaignShowService;
        $this->userDetailService = $userDetailService;
    }

    public function createWidgetsForCampaign($campaignId)
    {
        $result = array();
        try {
            $widgetTypes = WidgetTypesController::getWidgetTypeIds();
            foreach ($widgetTypes as $widgetType) {
                $id = $widgetType->id;
                $widgetSettingsDesktop = $this->initialWidgetSettings($campaignId, $id, 'desktop');
                $widgetSettingsTablet = $this->initialWidgetSettings($campaignId, $id, 'tablet');
                $widgetSettingsMobile = $this->initialWidgetSettings($campaignId, $id, 'mobile');
                $paymentType = ($id == 1) ? true : false;

                $widget = Widget::create([
                    'campaign_id' => $campaignId,
                    'widget_type_id' => $id,
                    'active' => false,
                    'payment_type' => $paymentType
                ]);

                // create Widget results
                $widget->result = WidgetResult::create([
                    'widget_id' => $widget->id,
                    'campaign_id' => $campaignId,
                    'widget_type_id' => $id,
                    'desktop' => '<div></div>',
                    'tablet' => '<div></div>',
                    'mobile' => '<div></div>'
                ]);

                $result[] = $widget;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update($rawWidgetData)
    {
        $id = $rawWidgetData->id;
        $widget = Widget::where('id', $id);
        $paymentType = (Widget::find($id)->where('widget_type_id', 1)->first() != null) ? true :
            $rawWidgetData['payment_type'];
        $widget->update([
            'active' => $rawWidgetData['active'],
            'use_campaign_settings' => false,
            'payment_type' => $paymentType
        ]);

        if ($rawWidgetData['contains_additional_widget_settings']) {
            foreach ($rawWidgetData['additional_widget_settings'] as $widgetSetting) {
                WidgetSettings::where('widget_id', $id)
                    ->update([
                        'desktop' => json_encode($widgetSetting['settings']['desktop']),
                        'tablet' => json_encode($widgetSetting['settings']['tablet']),
                        'mobile' => json_encode($widgetSetting['settings']['mobile']),
                        'active' => $widgetSetting['active']
                    ]);
            }
        } else {
            WidgetSettings::where('widget_id', $id)->update([
                'desktop' => json_encode($rawWidgetData['settings']['desktop']),
                'tablet' => json_encode($rawWidgetData['settings']['tablet']),
                'mobile' => json_encode($rawWidgetData['settings']['mobile'])
            ]);
        }
        if (CampaignImage::where('widget_id', $rawWidgetData->id)->first() == null &&
            $rawWidgetData['settings']['desktop']['widget_settings']['general']['background']['image']['url'] != null) {
            // create image mapping
            CampaignImage::create([
                'campaign_id' => Widget::find($id)->only('campaign_id')['campaign_id'],
                'widget_id' => $id,
                'image_id' => $rawWidgetData['settings']['desktop']['widget_settings']['general']['background']['image']['id'],
                'device_type' => 1 //desktop
            ]);
            if ($rawWidgetData['settings']['tablet']['widget_settings']['general']['background']['image']['url'] != null):
                CampaignImage::create([
                    'campaign_id' => Widget::find($id)->only('campaign_id')['campaign_id'],
                    'widget_id' => $id,
                    'image_id' => $rawWidgetData['settings']['tablet']['widget_settings']['general']['background']['image']['id'],
                    'device_type' => 2 //tablet
                ]);
            endif;
            if ($rawWidgetData['settings']['mobile']['widget_settings']['general']['background']['image']['url'] != null):
                CampaignImage::create([
                    'campaign_id' => Widget::find($id)->only('campaign_id')['campaign_id'],
                    'widget_id' => $id,
                    'image_id' => $rawWidgetData['settings']['mobile']['widget_settings']['general']['background']['image']['id'],
                    'device_type' => 3 //mobile
                ]);
            endif;
        } else {
            // update image mapping
            if ($rawWidgetData['settings']['desktop']['widget_settings']['general']['background']['image']['url'] != null):
                CampaignImage::where('widget_id', $id)->where('device_type', 1)->update([
                    'image_id' => $rawWidgetData['settings']['desktop']['widget_settings']['general']['background']['image']['id']
                ]);
            endif;
            if ($rawWidgetData['settings']['tablet']['widget_settings']['general']['background']['image']['url'] != null):
                CampaignImage::where('widget_id', $id)->where('device_type', 2)->update([
                    'image_id' => $rawWidgetData['settings']['tablet']['widget_settings']['general']['background']['image']['id']
                ]);
            endif;
            if ($rawWidgetData['settings']['mobile']['widget_settings']['general']['background']['image']['url'] != null):
                CampaignImage::where('widget_id', $id)->where('device_type', 3)->update([
                    'image_id' => $rawWidgetData['settings']['mobile']['widget_settings']['general']['background']['image']['id']
                ]);
            endif;
        }


        $user = Auth::user();
        $this->addTracking($id, $user->id, WidgetResource::make(Widget::find($id)));

        return $widget;
    }


    public function initialWidgetSettings($id, $widgetTypeId, $deviceType)
    {
        return $this->createSettingsJson($widgetTypeId, $deviceType);
    }

    private function getWidgetSettings($widgetType, $deviceType, $generalSettingsHeadlineText)
    {
        $result = array();
        switch ($widgetType) {
            case 2: // sidebar
                if ($deviceType == 'desktop') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'left',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'sidebar-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '79687',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 1,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/sidebar-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '10',
                                    'right' => '70',
                                    'bottom' => '15',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '330',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else if ($deviceType == 'tablet') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'locked-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '64507',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 2,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/locked-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '10',
                                    'right' => '70',
                                    'bottom' => '15',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'left',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'sidebar-default.jpg',
                                    'type' => 'image\/jpeg',
                                    'size' => '79687',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 1,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/sidebar-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '10',
                                    'right' => '70',
                                    'bottom' => '15',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '300',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                }
                break;
            case 3: // leaderboard
                if ($deviceType == 'desktop') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '10',
                                    'right' => '70',
                                    'bottom' => '15',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 26
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else if ($deviceType == 'tablet') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '20',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '10',
                                    'right' => '70',
                                    'bottom' => '15',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '30',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '10',
                                    'right' => '70',
                                    'bottom' => '15',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                }
                break;
            case 4: // popup
                if ($deviceType == 'desktop') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 32
                            ),
                            'background' => array(
                                'type' => 'color',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '70',
                                    'bottom' => '10',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '30',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 27
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else if ($deviceType == 'tablet') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 28
                            ),
                            'background' => array(
                                'type' => 'color',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '70',
                                    'bottom' => '10',
                                    'left' => '70'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 22
                            ),
                            'background' => array(
                                'type' => 'color',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '30',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '50',
                                    'bottom' => '10',
                                    'left' => '50'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                }
            case 5: // fixed
                if ($deviceType == 'desktop') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 25
                            ),
                            'background' => array(
                                'type' => 'color',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '12',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '30',
                                    'bottom' => '10',
                                    'left' => '30'
                                ),
                                'margin' => array(
                                    'top' => '8',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 27
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else if ($deviceType == 'tablet') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 20
                            ),
                            'background' => array(
                                'type' => 'color',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '10',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '30',
                                    'bottom' => '10',
                                    'left' => '30'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 18
                            ),
                            'background' => array(
                                'type' => 'color',
                                'image' => array(
                                    'path' => 'leaderboard-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '166682',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 3,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/leaderboard-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '30',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '30',
                                    'bottom' => '10',
                                    'left' => '30'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                }
                break;
            case 10: // article_advanced
            case 6: // locked
                if ($deviceType == 'desktop') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'left',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 27
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'locked-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '64507',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 2,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/locked-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => '12',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => '20'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '30',
                                    'bottom' => '10',
                                    'left' => '30'
                                ),
                                'margin' => array(
                                    'top' => '30',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 27
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else if ($deviceType == 'tablet') {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 27
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'locked-default.jpg',
                                    'type' => 'image\/jpeg',
                                    'size' => '64507',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 2,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/locked-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '30',
                                    'bottom' => '10',
                                    'left' => '30'
                                ),
                                'margin' => array(
                                    'top' => '30',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 24
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                } else {
                    $result = array(
                        'general' => array(
                            'fontSettings' => array(
                                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                                'alignment' => 'center',
                                'color' => '#FFFFFF',
                                'backgroundColor' => 'rgba(0,0,0,0)',
                                'fontSize' => 22
                            ),
                            'background' => array(
                                'type' => 'image',
                                'image' => array(
                                    'path' => 'locked-default.jpg',
                                    'type' => 'image/jpeg',
                                    'size' => '64507',
                                    'updated_at' => '',
                                    'created_at' => '',
                                    'id' => 2,
                                    'url' => env('ASSETS_URL') . '/public/images/widgets/locked-default.jpg'
                                ),
                                'color' => '#114b7d',
                                'opacity' => 100
                            ),
                            'text_margin' => array(
                                'top' => 'auto',
                                'right' => 'auto',
                                'bottom' => 'auto',
                                'left' => 'auto'
                            ),
                            'text_display' => null,
                            'text_background' => null,
                            'common_text' => array()
                        ),
                        'call_to_action' => array(
                            'default' => array(
                                'padding' => array(
                                    'top' => '5',
                                    'right' => '30',
                                    'bottom' => '10',
                                    'left' => '30'
                                ),
                                'margin' => array(
                                    'top' => '20',
                                    'right' => 'auto',
                                    'bottom' => '0',
                                    'left' => 'auto'
                                ),
                                'fontSettings' => array(
                                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                                    'fontWeight' => 400,
                                    'alignment' => 'center',
                                    'color' => '#FFFFFF',
                                    'fontSize' => 22
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#9e0b0f',
                                        'opacity' => 100,
                                        'selected' => true
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0,
                                        'selected' => true
                                    ),
                                    'radius' => array(
                                        'active' => true,
                                        'value' => '0',
                                        'selected' => true,
                                        'tl' => '10',
                                        'tr' => '10',
                                        'bl' => '10',
                                        'br' => '10'
                                    )
                                ),
                                'display' => 'relative'
                            ),
                            'hover' => array(
                                'type' => 'fade',
                                'fontSettings' => array(
                                    'fontWeight' => 'bold',
                                    'opacity' => 100,
                                    'color' => '#FFFFFF'
                                ),
                                'design' => array(
                                    'fill' => array(
                                        'active' => true,
                                        'color' => '#B71100',
                                        'opacity' => 100
                                    ),
                                    'border' => array(
                                        'active' => false,
                                        'color' => '#FFFFFF',
                                        'size' => 2,
                                        'opacity' => 0
                                    ),
                                    'shadow' => array(
                                        'active' => false,
                                        'color' => '#B71100',
                                        'x' => 2,
                                        'y' => 2,
                                        'b' => 2,
                                        'opacity' => 0
                                    ),
                                    'radius' => array(
                                        'active' => false,
                                        'value' => '0'
                                    )
                                )
                            )
                        )
                    );
                }
                break;
            default:
                break;
        }
        return $result;
    }

    private function headlineSettingText($widgetType, $deviceType, $generalWidgetSettings)
    {
        $result = '';
        switch ($widgetType) {
            case 3: // leaderboard
                if ($deviceType == 'desktop') {
                    $result = '<b>We can write because of your&nbsp;</b><div><b>financial support.</b></div>';
                } else if ($deviceType == 'tablet') {
                    $result = 'We can write because of your<div>&nbsp;financial support.</div>';
                } else {
                    $result = $generalWidgetSettings;
                }
                break;
            case 4: // popup
                if ($deviceType == 'desktop') {
                    $result = '<b>Thank you for reading, please&nbsp;</b><div><b>support independency&nbsp;</b><div><b>of this media.</b></div></div>';
                } else if ($deviceType == 'tablet') {
                    $result = '<span><b>Thank you for reading, please&nbsp;</b></span><div><b>support independency&nbsp;</b><div><b>of this media.</b></div></div>';
                } else {
                    $result = '<span><b>Thank you for reading, please&nbsp;</b></span><div><b>support independency&nbsp;</b><div><b>of this media.</b></div></div>';
                }
                break;
            case 5: //fixed
                $result = '<b>Thank you for reading, please&nbsp;support independency&nbsp;of this media.</b>';
                break;
            case 6: // locked
                if ($deviceType == 'mobile') {
                    $result = '<b>We can write because of your financial support.</b>';
                } else {
                    $result = '<b>We can write&nbsp;</b><div><b>because of your</b></div><div><span><b>financial support.</b></span></div>';
                }
                break;
            default:
                $result = $generalWidgetSettings;
        }
        return $result;
    }

    public function createSettingsJson($widgetType, $deviceType)
    {
        $this->widgetSettings = $this->widgetSettingsStructure();
        // GET GENERAL CAMPAIGN SETTINGS
        $generalSettings = $this->getGeneralSettings();
        $this->paymentSettings = $this->paymentSettingsStructure($widgetType, $deviceType);
        $generalWidgetSettings = json_decode($generalSettings['widget_settings'], true);
        $generalSettingsHeadlineText = json_decode($generalSettings['font_settings_headline_text'], true);

        if ($widgetType !== 1 && $widgetType !== 9 && $widgetType !== 7) { // all except landing, article and custom
            // override settings with Postoj default settings
            $result = array(
                'headline_text' => $this->headlineSettingText($widgetType, $deviceType, $generalWidgetSettings['headline_text']['text']),
                'widget_settings' => $this->getWidgetSettings($widgetType, $deviceType, $generalSettingsHeadlineText),
                'payment_settings' => $this->paymentSettings,
                'email_settings' => array(
                    'active' => false,
                    'subscribe_text' => ''
                ),
                'cta' => array(
                    'text' => $generalWidgetSettings['cta']['text'],
                    'url' => $generalWidgetSettings['cta']['url']
                ),
                'additional_settings' =>
                    $this->getAdditionalWidgetSettings($widgetType, $generalSettings, $deviceType)

            );
            $result['widget_settings']['additional_text'] = array(
                'text' => $generalWidgetSettings['additional_text']['text'],
                'fontSettings' => array(
                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                    'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                    'alignment' => 'center',
                    'color' => $generalSettingsHeadlineText['color'],
                    'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                    'fontSize' => 18
                ),
                'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                'text_margin' => array(
                    'top' => '0',
                    'right' => 'auto',
                    'bottom' => '0',
                    'left' => 'auto'
                )
            );
            $result['widget_settings']['additional_text'] = array(
                'text' => '',
                'fontSettings' => array(
                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                    'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                    'alignment' => 'center',
                    'color' => $generalSettingsHeadlineText['color'],
                    'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                    'fontSize' => 18
                ),
                'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                'text_margin' => array(
                    'top' => '0',
                    'right' => 'auto',
                    'bottom' => '0',
                    'left' => 'auto'
                )
            );

        } else {

            $articleWidgetText = null;
            if ($widgetType == 7) {
                $articleWidgetText = '<p><b><font color="#004080">Thank you for reading this article.</font></b></p><p><b><font color=\"#004080\">Our articles are made only</font></b></p><p><b><font color="#114b7d">by our subscribers.<\/font><\/b><\/p><p><i>Lorem ipsum ...<\/i><\/p><p><b><a href="/podpora"><font color="#cc0000">Be our subscriber now!</font></a></b></p><p><b><font color="#114b7d">Thanks!</font></b></p>';
            }

            $generalCtaSettings = json_decode($generalSettings['cta'], true);
            $this->widgetSettings['general']['fontSettings'] = $this->overrideGeneralSettings('headlineFonts', array(
                'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                'alignment' => 'center',
                'color' => $generalSettingsHeadlineText['color'],
                'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                'fontSize' => $generalSettingsHeadlineText['fontSize']
            ), $widgetType);

            $this->widgetSettings['general']['background'] = array(
                'type' => 'image',
                'image' => array(
                    'path' => 'landing.jpg',
                    'id' => 4,
                    'type' => 'image/jpeg',
                    'updated_at' => '',
                    'created_at' => '',
                    'url' => env('ASSETS_URL') . '/public/images/widgets/landing.jpg'),
                'color' => $generalWidgetSettings['backgroundColor'],
                'opacity' => 100
            );

            $this->widgetSettings['general']['text_margin'] = $this->overrideGeneralSettings('headlineMargin', $this->widgetSettings['general']['text_margin'], $widgetType);

            $this->widgetSettings['call_to_action'] = $this->overrideGeneralSettings('cta', $generalCtaSettings, $widgetType);

            // Additional text
            $this->widgetSettings['additional_text'] = array(
                'text' => $generalWidgetSettings['additional_text']['text'],
                'fontSettings' => array(
                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                    'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                    'alignment' => 'center',
                    'color' => $generalSettingsHeadlineText['color'],
                    'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                    'fontSize' => 18
                ),
                'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                'text_margin' => array(
                    'top' => '0',
                    'right' => 'auto',
                    'bottom' => '0',
                    'left' => 'auto'
                )
            );

            $this->widgetSettings['additional_text_bottom'] = array(
                'text' => '',
                'fontSettings' => array(
                    'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
                    'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
                    'alignment' => 'center',
                    'color' => $generalSettingsHeadlineText['color'],
                    'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                    'fontSize' => 18
                ),
                'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
                'text_margin' => array(
                    'top' => '0',
                    'right' => 'auto',
                    'bottom' => '0',
                    'left' => 'auto'
                )
            );


            $result = array(
                'headline_text' => $generalWidgetSettings['headline_text']['text'],
                'articleWidgetText' => $articleWidgetText,
                'widget_settings' => $this->widgetSettings,
                'payment_settings' => $this->paymentSettings,
                'email_settings' => array(
                    'active' => false,
                    'subscribe_text' => ''
                ),
                'cta' => array(
                    'text' => $generalWidgetSettings['cta']['text'],
                    'url' => $generalWidgetSettings['cta']['url']
                ),
                'additional_settings' =>
                    $this->getAdditionalWidgetSettings($widgetType, $generalSettings, $deviceType)

            );

        }


        return $result;
    }

    public function getGeneralSettings()
    {
        return CampaignsConfiguration::where('id', 1)->get()[0];
    }

    /*
    * Override Payment options
    */
    public function overrideMonetization($deviceType, $settings, $widgetTypeId)
    {
        $typeId = $deviceType->id;
        $overridedSettings = $settings;

        $overridedSettings['payment_settings']['design']['padding']['top'] = '5';
        $overridedSettings['payment_settings']['design']['padding']['right'] = '5';
        $overridedSettings['payment_settings']['design']['padding']['bottom'] = '5';
        $overridedSettings['payment_settings']['design']['padding']['left'] = '5';


        $overridedSettings['payment_settings']['design']['margin']['top'] = '40';
        $overridedSettings['payment_settings']['design']['margin']['right'] = '0';
        $overridedSettings['payment_settings']['design']['margin']['bottom'] = '5';
        $overridedSettings['payment_settings']['design']['margin']['left'] = '5';

        // Landing Page Widget
        if ($widgetTypeId == 1):
            switch ($typeId) {
                case 1: // desktop
                    $overridedSettings['payment_settings']['design']['width'] = '532px';
                    $overridedSettings['payment_settings']['design']['padding']['top'] = '25';
                    $overridedSettings['payment_settings']['design']['padding']['right'] = '55';
                    $overridedSettings['payment_settings']['design']['padding']['bottom'] = '25';
                    $overridedSettings['payment_settings']['design']['padding']['left'] = '55';
                    $overridedSettings['payment_settings']['design']['shadow']['opacity'] = 1;
                    $overridedSettings['additional_settings']['buttonContainer']['position'] = 'relative';
                    $overridedSettings['additional_settings']['buttonContainer']['textAlign'] = 'center';
                    break;
                case 2: // tablet
                    $overridedSettings['payment_settings']['design']['width'] = '532px';
                    $overridedSettings['payment_settings']['design']['padding']['top'] = '25';
                    $overridedSettings['payment_settings']['design']['padding']['right'] = '55';
                    $overridedSettings['payment_settings']['design']['padding']['bottom'] = '25';
                    $overridedSettings['payment_settings']['design']['padding']['left'] = '55';
                    $overridedSettings['payment_settings']['design']['shadow']['opacity'] = 1;
                    $overridedSettings['additional_settings']['buttonContainer']['position'] = 'relative';
                    $overridedSettings['additional_settings']['buttonContainer']['textAlign'] = 'center';
                    break;
                case 3: // mobile
                    $overridedSettings['payment_settings']['design']['width'] = 'auto';
                    $overridedSettings['payment_settings']['design']['padding']['top'] = '24';
                    $overridedSettings['payment_settings']['design']['padding']['right'] = '24';
                    $overridedSettings['payment_settings']['design']['padding']['bottom'] = '24';
                    $overridedSettings['payment_settings']['design']['padding']['left'] = '24';
                    $overridedSettings['payment_settings']['design']['shadow']['opacity'] = 1;
                    $overridedSettings['additional_settings']['buttonContainer']['position'] = 'relative';
                    $overridedSettings['additional_settings']['buttonContainer']['textAlign'] = 'center';
                    break;

                default:
                    break;
            }
        endif;

        // Hide CTA and Headline text for monetization widget as default
        if ($overridedSettings['payment_settings']['active']) {
            $overridedSettings['headline_text'] = '';
        }

        return json_encode($overridedSettings);
    }

    public function widgetSettingsStructure()
    {
        $structure = array(
            'general' => array(
                'fontSettings' => array(),
                'background' => array(),
                'text_margin' => array(),
                'text_display' => '',
                'text_background' => '',
                'common_text' => array()
            ),
            'call_to_action' => array(
                'default' => array(
                    'width' => 'auto',
                    'padding' => array(),
                    'margin' => array(),
                    'fontSettings' => array(),
                    'design' => array(
                        'fill' => array(),
                        'border' => array(),
                        'shadow' => array(),
                        'radius' => array()
                    )
                ),
                'hover' => array(
                    'type' => '',
                    'fontSettings' => array(),
                    'design' => array(
                        'fill' => array(),
                        'border' => array(),
                        'shadow' => array(),
                        'radius' => array()
                    )
                )
            )
        );
        return $structure;
    }

    public function updateWidgetSettingsFromCampaign($campaignId, $promoteSettings)
    {
        try {
            $widgets = Widget::all()->where('campaign_id', $campaignId);
            foreach ($widgets as $w) {
                // if use_campaign_settings == true --> use campaign settings in update campaign
                if ($w->use_campaign_settings) {
                    $widgetId = $w->id;
                    $settings = json_encode($this->createSettingsJson($promoteSettings, $w->widget_type_id));
                    WidgetSettings::where('widget_id', $widgetId)->update([
                        'desktop' => $settings,
                        'tablet' => $settings,
                        'mobile' => $settings
                    ]);
                }
            }
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function overrideGeneralSettings($type, $settings, $widgetType)
    {
        $output = $settings;
        if ($type == 'cta') {
            switch ($widgetType) {
                case 1: // landing widget
                    $output = $settings;
                    $output['hover']['fontSettings']['fontWeight'] = 'Medium';
                    $output['default']['width'] = '100%';
                    $output['default']['padding'] = array(
                        'top' => '12',
                        'right' => '0',
                        'bottom' => '12',
                        'left' => '0'
                    );
                    $output['default']['fontSettings']['alignment'] = 'center';
                    break;
                case 2: // sidebar widget
                    $output = $settings;
                    $output['default']['display'] = 'relative';
                    $output['default']['margin'] = array(
                        'top' => '420',
                        'right' => 'auto',
                        'bottom' => '0',
                        'left' => 'auto'
                    );
                    $output['default']['padding'] = array(
                        'top' => '15',
                        'right' => '70',
                        'bottom' => '20',
                        'left' => '70'
                    );
                    break;
                case 3: // leaderboard
                    $output = $settings;
                    $output['default']['margin'] = array(
                        'top' => '100',
                        'right' => 'auto',
                        'bottom' => '0',
                        'left' => 'auto'
                    );
                    $output['default']['padding'] = array(
                        'top' => '20',
                        'right' => '70',
                        'bottom' => '25',
                        'left' => '70'
                    );
                    break;
                default:
                    $output = $settings;
            }
        } else if ($type == 'headlineFonts') {
            switch ($widgetType) {
                case 1: // landing widget
                    $output = $settings;
                    break;
                case 2: // sidebar widget
                    $output['alignment'] = 'left';
                    break;
                case 3: // leaderboard widget
                    $output['fontSize'] = 50;
                default:
                    $output = $settings;
            }
        } else if ($type == 'headlineMargin') {
            switch ($widgetType) {
                case 1: // landing widget
                    $output = $settings;
                    break;
                case 2: // sidebar widget
                    $output = $settings;
                    break;
                case 3: // leaderboard
                    $output = array(
                        'top' => '30',
                        'right' => 'auto',
                        'bottom' => '0',
                        'left' => 'auto'
                    );
                    break;
                default:
                    $output = $settings;
            }
        }
        return $output;
    }

    public function paymentSettingsStructure($widgetTypeId, $deviceType)
    {
        $structure = array(
            'active' => ($widgetTypeId == 1) ? true : false,
            'payment_type' => 'both',
            'type' => 'classic',
            'monetization_title' => array(
                'fontSettings' => array(
                    'fontFamily' => 'Roboto Slab',
                    'fontWeight' => '700',
                    'backgroundColor' => '#fff',
                    'fontSize' => 21
                ),
                'margin' => array(
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '30',
                    'left' => '0'
                ),
                'text' => 'We can write because of your financial support',
                'textColor' => '#1f4e7b',
                'alignment' => 'center'
            ),
            'design' => array(
                'background_color' => '#ffffff',
                'padding' => array(
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => ''
                ),
                'margin' => array(
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => ''
                ),
                'width' => '100%',
                'height' => 'auto',
                'text_color' => '#1f4e7b',
                'shadow' => array(
                    'color' => '#77777',
                    'opacity' => 0,
                    'x' => 3,
                    'y' => 3,
                    'b' => 3
                )
            ),
            'monthly_prices' => array(
                'custom_price' => true,
                'count_of_options' => 5,
                'count_of_options_in_row' => 3,
                'options' => array(
                    array(
                        'title' => '',
                        'description' => '',
                        'value' => 30
                    ),
                    array(
                        'title' => 'VIP člen klubu',
                        'description' => '<div><ul><li><b>tlačené noviny</b> raz ročne</li><li>darček - <b>kniha </b>len pre darcov</li><li><b>zľava na knihy</b> z vydavatelstva Postoj</li><li><b>VIP vstup</b> na eventy Postoj</li></ul></div>',
                        'value' => 20
                    ),
                    array(
                        'title' => '',
                        'description' => '',
                        'value' => 15
                    ),
                    array(
                        'title' => 'Člen Klubu Postoj',
                        'description' => '<div><ul><li><b>tlačené noviny</b> raz ročne</li><li>darček - <b>kniha </b>len pre darcov</li><li><b>zľava na knihy</b> z vydavatelstva Postoj</li></ul></div>',
                        'value' => 10
                    ),
                    array(
                        'title' => 'Čestný čitateľ postoj Postoj',
                        'description' => '<ul><li><b>tlačené noviny</b> raz ročne</li></ul>',
                        'value' => 5
                    ),
                ),
                'benefit' => array(
                    'active' => true,
                    'text' => 'Donate 10 € or more monthly to <b>become a premium member</b>',
                    'value' => 10
                ),
                'benefits' => array(
                    array(
                        'id' => 1,
                        'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                    ),
                    array(
                        'id' => 2,
                        'text' => '<b>tlačené noviny</b> raz ročne'
                    ),
                    array(
                        'id' => 3,
                        'text' => 'Darček - <b>kniha</b> len pre darcov'
                    ),
                    array(
                        'id' => 4,
                        'text' => '<b>Zľava na knihy</b> z vydavatelstva Postoj'
                    ),
                    array(
                        'id' => 5,
                        'text' => '<b>VIP vstup</b> na eventy Postoj'
                    ),
                    array(
                        'id' => 6,
                        'text' => 'Pozvánka na diskusné večery s redaktormi'
                    ),
                    array(
                        'id' => 7,
                        'text' => '<b>špeciálny darček z Postoja</b>'
                    )
                ),
                'columns_count' => 3,
                'columns' => array(
                    array(
                        'header' => array(
                            'enable' => false,
                            'text' => 'BEST OPTION',
                            'color' => '#fff',
                            'background_color' => '#2178CB'
                        ),
                        'title' => 'Čestný čitateľ Postoj',
                        'active_benefits' => [
                            array(
                                'id' => 1,
                                'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                            ),
                        ],
                        'show_benefits' => [
                            array(
                                'id' => 1,
                                'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                            ),
                            array(
                                'id' => 3,
                                'text' => 'Darček - <b>kniha</b> len pre darcov'
                            ),
                            array(
                                'id' => 4,
                                'text' => '<b>Zľava na knihy</b> z vydavatelstva Postoj'
                            ),
                            array(
                                'id' => 5,
                                'text' => '<b>VIP vstup</b> na eventy Postoj'
                            ),
                            array(
                                'id' => 6,
                                'text' => 'Pozvánka na diskusné večery s redaktormi'
                            ),
                        ],
                        'custom_price' => false,
                        'count_of_options' => 2,
                        'count_of_options_in_row' => 2,
                        'options' => array(
                            array('value' => 5),
                            array('value' => 7)
                        )
                    ),
                    array(
                        'header' => array(
                            'enable' => true,
                            'text' => 'OBĽÚBENÁ VOĽBA',
                            'color' => '#fff',
                            'background_color' => '#2178CB'
                        ),
                        'title' => 'Člen Klubu Postoj',
                        'active_benefits' => [
                            array(
                                'id' => 1,
                                'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                            ),
                            array(
                                'id' => 2,
                                'text' => '<b>tlačené noviny</b> raz ročne'
                            ),
                            array(
                                'id' => 3,
                                'text' => 'Darček - <b>kniha</b> len pre darcov'
                            ),
                            array(
                                'id' => 4,
                                'text' => '<b>Zľava na knihy</b> z vydavatelstva Postoj'
                            ),
                        ],
                        'show_benefits' => [
                            array(
                                'id' => 1,
                                'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                            ),
                            array(
                                'id' => 2,
                                'text' => '<b>tlačené noviny</b> raz ročne'
                            ),
                            array(
                                'id' => 3,
                                'text' => 'Darček - <b>kniha</b> len pre darcov'
                            ),
                            array(
                                'id' => 4,
                                'text' => '<b>Zľava na knihy</b> z vydavatelstva Postoj'
                            ),
                            array(
                                'id' => 5,
                                'text' => '<b>VIP vstup</b> na eventy Postoj'
                            ),
                            array(
                                'id' => 6,
                                'text' => 'Pozvánka na diskusné večery s redaktormi'
                            ),
                        ],
                        'custom_price' => false,
                        'count_of_options' => 2,
                        'count_of_options_in_row' => 2,
                        'options' => array(
                            array('value' => 10),
                            array('value' => 20)
                        )
                    ),
                    array(
                        'header' => array(
                            'enable' => false,
                            'text' => 'BEST OPTION',
                            'color' => '#fff',
                            'background_color' => '#2178CB'
                        ),
                        'title' => 'VIP člen klubu',
                        'active_benefits' => [
                            array(
                                'id' => 1,
                                'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                            ),
                            array(
                                'id' => 2,
                                'text' => '<b>tlačené noviny</b> raz ročne'
                            ),
                            array(
                                'id' => 3,
                                'text' => 'Darček - <b>kniha</b> len pre darcov'
                            ),
                            array(
                                'id' => 4,
                                'text' => '<b>Zľava na knihy</b> z vydavatelstva Postoj'
                            ),
                            array(
                                'id' => 5,
                                'text' => '<b>VIP vstup</b> na eventy Postoj'
                            ),
                            array(
                                'id' => 7,
                                'text' => '<b>špeciálny darček z Postoja</b>'
                            )
                        ],
                        'show_benefits' => [
                            array(
                                'id' => 1,
                                'text' => '<b>pomáhate tvoriť kvalitnú žurnalistiku</b>'
                            ),
                            array(
                                'id' => 2,
                                'text' => '<b>tlačené noviny</b> raz ročne'
                            ),
                            array(
                                'id' => 3,
                                'text' => 'Darček - <b>kniha</b> len pre darcov'
                            ),
                            array(
                                'id' => 4,
                                'text' => '<b>Zľava na knihy</b> z vydavatelstva Postoj'
                            ),
                            array(
                                'id' => 5,
                                'text' => '<b>VIP vstup</b> na eventy Postoj'
                            ),
                            array(
                                'id' => 7,
                                'text' => '<b>špeciálny darček z Postoja</b>'
                            )
                        ],
                        'custom_price' => true,
                        'count_of_options' => 1,
                        'count_of_options_in_row' => 2,
                        'options' => array(
                            array('value' => 30)
                        )
                    )
                )
            ),
            'once_prices' => array(
                'custom_price' => true,
                'count_of_options' => 5,
                'count_of_options_in_row' => 3,
                'options' => array(
                    array(
                        'value' => 200
                    ),
                    array(
                        'value' => 100
                    ),
                    array(
                        'value' => 60
                    ),
                    array(
                        'value' => 30
                    ),
                    array(
                        'value' => 20
                    ),
                ),
                'benefit' => array(
                    'active' => true,
                    'text' => 'Donate 100 € or more to become a premium member',
                    'value' => 100
                )
            ),
            'price_background_color' => 'inherit',
            'price_text_color' => 'inherit',
            'default_price' => array(
                'monthly_active' => true,
                'monthly_value' => 20,
                'one_time_active' => true,
                'one_time_value' => 100,
                'styles' => array(
                    'background' => "#3cc300",
                    'color' => "#ffffff"
                ),
            ),
            'second_step' => array(
                'title' => array(
                    'text' => 'title'
                ),
                'cta' => array(
                    'transfer' => array(
                        'text' => 'Go to your bank'
                    ),
                    'payBySquare' => array(
                        'text' => 'Go to your bank'
                    )
                ),
            ),
            'third_step' => array(
                'title' => array(
                    'text' => 'Thank you for your support'
                ),

                'cta' => array(
                    'description' => 'To get all rewards please  fill your personal data in My profile',
                    'text' => 'My profile'
                )),
            'terms' => array(
                'text' => 'I agree to processing of personal data and receiving sletters'
            )
        );
        switch ($deviceType) {
            case 'desktop':
                break;
            case 'tablet':
                break;
            case 'mobile':
                //change number of options in one row from 3 to 2
                $structure['monthly_prices']['count_of_options_in_row'] = 2;
                $structure['once_prices']['count_of_options_in_row'] = 2;
                break;
        }
        return $structure;
    }

    public function getAdditionalWidgetSettings($widgetType, $generalSettings, $deviceType)
    {
        $outputJson = array();
        switch ($widgetType) {
            case 1: // landing widget
                $outputJson = array(
                    'width' => '100%',
                    'height' => '688px',
                    'position' => 'relative',
                    'fixedSettings' => array(),
                    'display' => 'block',
                    'padding' => array(
                        'top' => '0',
                        'right' => '0',
                        'bottom' => '0',
                        'left' => '0'
                    ),
                    'bodyContainer' => array(
                        'width' => '100%',
                        'margin' => array(
                            'top' => '0',
                            'right' => 'auto',
                            'bottom' => '0',
                            'left' => 'auto'
                        ),
                        'position' => 'relative',
                        'top' => '80px',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'text' => array(
                            'width' => '100%'
                        )
                    ),
                    'textContainer' => array(
                        'width' => '50%',
                        'margin' => array(
                            'top' => '0',
                            'right' => 'auto',
                            'bottom' => '0',
                            'left' => 'auto'
                        ),
                        'position' => 'absolute',
                        'top' => '80px',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'text' => array(
                            'width' => '100%'
                        )
                    ),
                    'buttonContainer' => array(
                        'width' => '100%',
                        'position' => 'absolute',
                        'top' => '50px',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'textAlign' => 'center',
                        'button' => array(
                            'width' => '35%',
                            'display' => 'inline-block',
                        )
                    )
                );
                break;
            case 2: // sidebar widget
                $outputJson = ($deviceType === 'desktop')
                    ? $this->sidebarWidget->initDesktop() :
                    (($deviceType === 'tablet') ? $this->sidebarWidget->initTablet()
                        : $this->sidebarWidget->initMobile());
                break;
            case 3: // leaderboard
                $outputJson = ($deviceType === 'desktop')
                    ? $this->leaderboardWidget->initDesktop() :
                    (($deviceType === 'tablet') ? $this->leaderboardWidget->initTablet()
                        : $this->leaderboardWidget->initMobile());
                break;
            case 4: // popup
                $outputJson = ($deviceType === 'desktop')
                    ? $this->popupWidget->initDesktop() :
                    (($deviceType === 'tablet') ? $this->popupWidget->initTablet()
                        : $this->popupWidget->initMobile());
                break;
            case 5: // fixed widget
                $outputJson = ($deviceType === 'desktop')
                    ? $this->fixedWidget->initDesktop() :
                    (($deviceType === 'tablet') ? $this->fixedWidget->initTablet()
                        : $this->fixedWidget->initMobile());
                break;
            case 10: // article_advanced
            case 6: // locked article
                $outputJson = ($deviceType === 'desktop')
                    ? $this->lockedArticleWidget->initDesktop() :
                    (($deviceType === 'tablet') ? $this->lockedArticleWidget->initTablet()
                        : $this->lockedArticleWidget->initMobile());
                break;
            case 7: // article widget
                // widget with rich text only (you can set raw text with hyperlinks / colors
                $outputJson = ($deviceType === 'desktop')
                    ? $this->articleWidget->initDesktop() :
                    (($deviceType === 'tablet') ? $this->articleWidget->initTablet()
                        : $this->articleWidget->initMobile());
                break;
            case 9: // custom html + css
                $outputJson = array(
                    'customHtmlWidget' => '<div style="display: block; padding: 15px; background: #ccc; color: #000000;">This is your html widget</div>'
                );
                break;
            default:
                break;
        }
        return $outputJson;
    }

    public function addTracking($widgetId, $userId, $data)
    {
        $campaignVersion = WidgetVersion::create([
            'widget_id' => $widgetId,
            'user_id' => $userId,
            'widget_data' => json_encode($data)
        ]);
        try {
            $campaignVersion->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully created version of widget.'
        ], Response::HTTP_CREATED);
    }

    public function get($id)
    {
        return Widget::find($id);
    }

    public function getWidgetsByCampaignId($campaignId)
    {
        return Widget::orderBy('active', 'desc')
            ->with('widgetSettings')
            ->with('campaignImage')
            ->with('widgetResults')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->where('campaign_id', $campaignId);
        // ->whereIn('widget_type_id', [1, 2, 3, 5]);
    }

    /**
     * @param Request $request
     */
    public function updateResults($request): void
    {
// campaign id ($id) is not in use at the moment
        foreach ($request['widgets'] as $widget) {
            if (Widget::find($widget['id'])->use_campaign_settings) {
                WidgetResult::where('widget_id', $widget['id'])
                    ->update([
                        'desktop' => $widget['desktop'],
                        'tablet' => $widget['tablet'],
                        'mobile' => $widget['mobile']
                    ]);
            }
        }
    }

    /**
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampaignWidgets($user): \Illuminate\Http\JsonResponse
    {
        if ($user == null) {
            // unregistered user
            //TODO: na toto je uz iny endpoint, pre neprihlasenych. (premazat?)
            // TODO: na strane frontendu cez localstorage/cookies kontrolovat kolko clankov uz precital user

            $actualDate = date('Y-m-d');
            $campaignIds = Campaign::with('targeting')
                ->where('active', true)
                ->where('date_to', '>=', $actualDate)
                ->whereHas('targeting', function ($query) {
                    $query->where('not_signed', true);
                })
                ->pluck('id');

            $randomResponse =
                Widget::inRandomOrder()
                    ->get()
                    ->where('active', true)
                    ->whereIn('campaign_id', $campaignIds)
                    ->whereIn('widget_type_id', [2, 3, 5]);
            $onlyThreeWidgets = array();
            $usedWidgetIds = array();

            foreach ($randomResponse as $rand) {
                if (!in_array($rand['widget_type_id'], $usedWidgetIds)) {
                    array_push($onlyThreeWidgets, WidgetResultResource::make($rand));
                    array_push($usedWidgetIds, $rand['widget_type_id']);
                }
            }
            return $onlyThreeWidgets;

        } else {
            // user data (is user donator?) with targeting
            $userId = $user->id;


            // check readArticles, donations

            $actualDate = date('Y-m-d');

            $campaignIds = Campaign::with('targeting')
                ->where('active', true)
                ->where('date_to', '>=', $actualDate)
                ->whereHas('targeting', function ($query) {
                    $query->where('signed', true);
                })
                ->pluck('id');

            $randomResponse =
                Widget::inRandomOrder()
                    ->get()
                    ->where('active', true)
                    ->whereIn('campaign_id', $campaignIds)
                    ->whereIn('widget_type_id', [2, 3, 5]);
            $onlyThreeWidgets = array();
            $usedWidgetIds = array();
            foreach ($randomResponse as $rand) {
                if (!in_array($rand['widget_type_id'], $usedWidgetIds)) {
                    array_push($onlyThreeWidgets, WidgetResultResource::make($rand));
                    array_push($usedWidgetIds, $rand['widget_type_id']);
                }
            }
        }
    }

    /**
     * @param $campaign
     * @return \Illuminate\Database\Eloquent\Collection|Widget[]
     */
    public function getWidgetsByCampaginReduced($campaign)
    {
        return Widget::all()
            ->where('campaign_id', $campaign->id)->whereIn('widget_type_id', [1, 2, 3, 5]);
    }

    public function closePopupFixedWidget($user_cookie, $widget_id)
    {
        $widget = Widget::where('id', $widget_id)->first();
        CampaignsVisited::where('campaign_id', $widget->campaign_id)->where('user_cookie', $user_cookie)->update([
            'click_on_x' => true
        ]);
    }


    /**
     * @return array
     */
    public function getWidgets($url, $article, $special, $userCookie, $userToken, $referalWidgetId, $ip, $popupTime)
    {
        // TESTING EMAIL
        //Mail::to('ondas.stevo@gmail.com')->send(new DonationEmail(null, null, '**** **** **** 1234', 'cardExpiration', 'monthly', null));

        // Comfortpay testing
//        $comfortpayService = new ComfortPayService();
//        dd($comfortpayService->ping());

        $user = (JWTAuth::getToken())
            ? ((JWTAuth::check()) ? JWTAuth::parseToken()->authenticate() : null)
            : null;

        if ($special === 'is_user_account') {
            $availableWidgets = Widget::get()
                ->where('active', true)
                ->whereIn('campaign_id', 1); // default campaign

            //get widgets but only one for specific widget_type_id.
            $widgetDistinctType = array();
            $usedWidgetIds = array();
            $usedCampaignIds = array();
            $userId = $user['id'];
            $portalUserId = $this->portalUserService->getPortalUserIdByUserId($userId);
            //track visit
            $trackingVisit = $this->trackingService->createVisit($portalUserId, null, $url, null);

            //filter campaigns - get users data -read articles
            $readArticles = $this->articleService->getNumberOfArticlesPortalUser($portalUserId);
            $validAddress = JWTAuth::parseToken()->getPayload()['valid_address'];
            if ($validAddress == null) {
                $userDetail = $this->userDetailService->getByUserId($userId);
                $validAddress = $this->userService->userHaveValidAddress($userDetail);
            }
            $userData = new UserData(true, $readArticles);
            $userData->setValidAddress($validAddress);
            $campaigns = $this->campaignRepository->getActiveCampaigns($userData, $url, '', '');
            //filter campaigns - get users data - donations
            $donations = $this->donationService->getDonationsByPortalUserId($portalUserId);

            $this->trackingCampaignShowS->getByPortalUserId($portalUserId);
            foreach ($availableWidgets as $widget) {
                if (!in_array($widget['widget_type_id'], $usedWidgetIds)) {
                    $widget['widget_id'] = $widget['id'];
                    array_push($widgetDistinctType, WidgetResultResource::make($widget));
                    array_push($usedWidgetIds, $widget['widget_type_id']);
                    if (!in_array($widget['campaign_id'], $usedCampaignIds)) {
                        array_push($usedCampaignIds, $widget['campaign_id']);
                    }
                }
            }
            $result['widgets'] = $widgetDistinctType;
            //append addition properties to help tracking with user tracking
            $result['tracking_visit_id'] = $trackingVisit->id;
            $result['user_cookie'] = $userCookie;
            return $result;
        }

        //only for page, where is landing page, a.k.a. fero
        if ($special === 'support') {
            //logged user
            if ($user !== null && $user !== false) {
                $userId = $user['id'];
                $portalUserId = $this->portalUserService->getPortalUserIdByUserId($userId);
                //track visit
                $trackingVisit = $this->trackingService->createVisit($portalUserId, null, $url, null);
            } else {
                //create new cookie, if user dont send any cookie
                if ($userCookie == null || $userCookie == "" || $userCookie == "null" || $userCookie == "undefined") {
                    $cookie = $this->userService->createCookieIfNew($ip);
                    $userCookie = $cookie->id;
                } else if ($userCookie !== null && $userCookie !== null && $userCookie !== 'null' && $userCookie !== 'undefined') {
                    if (sizeof($this->trackingCampaignShowS->getByUserCookieId($userCookie)) === 0) {
                        $cookie = $this->userService->createCookieIfNew($ip);
                        $userCookie = $cookie->id;
                    }
                }
                //track visit
                $trackingVisit = $this->trackingService->createVisit(null, $userCookie, $url, null);
            }
            //request without referal widget id always return default landing page.
            if ($referalWidgetId === null) {
                $landingWidget = Widget::get()->where('campaign_id', 1)->where('widget_type_id', 1)->first();
            } else {
                $landingWidget = $this->getLandingOfCampaignContainingWidget($referalWidgetId);
                if ($landingWidget === null) {
                    $landingWidget = Widget::get()->where('campaign_id', 1)->where('widget_type_id', 1)->first();
                }

            }
            $landingWidget['widget_id'] = $landingWidget['id'];
            $result['widgets'] = [WidgetResultResource::make($landingWidget)];
            //append addition properties to help tracking with user tracking
            $result['tracking_visit_id'] = $trackingVisit->id;
            $result['user_cookie'] = $userCookie;

            return $result;
        }

        //handle article
        $articleId = null;
        if ($article != null) {
            $articleId = $this->articleService->createArticleIfDontExist($article)->id;
        }

        $author = ($article !== null) ? $article['author'] : null;
        $category = ($article !== null) ? $article['category_title'] : null;

        //logged user
        if ($user !== null && $user !== false) {
            $userId = $user['id'];
            $portalUserId = $this->portalUserService->getPortalUserIdByUserId($userId);
            //track visit
            $trackingVisit = $this->trackingService->createVisit($portalUserId, null, $url, $articleId);

            //filter campaigns - get users data -read articles
            $readArticles = $this->articleService->getNumberOfArticlesPortalUser($portalUserId);
            $validAddress = JWTAuth::parseToken()->getPayload()['valid_address'];
            if ($validAddress == null) {
                $userDetail = $this->userDetailService->getByUserId($userId);
                $validAddress = $this->userService->userHaveValidAddress($userDetail);
            }
            $userData = new UserData(true, $readArticles);
            $userData->setValidAddress($validAddress);

            $campaigns = $this->campaignRepository->getActiveCampaigns($userData, $url, $author, $category);
            //filter campaigns - get users data - donations
            $donations = $this->donationService->getDonationsByPortalUserIdWithPaymentId($portalUserId);
            $campaigns = $this->donationService->filterCampaignByTargetingAndDonations($campaigns, $donations);

            $trackingCampaignShow = $this->trackingCampaignShowS->getByPortalUserId($portalUserId);
        } else {
            //create new cookie, if user dont send any cookie
            if ($userCookie == null || $userCookie == "" || $userCookie == "null" || $userCookie == "undefined") {
                $cookie = $this->userService->createCookieIfNew($ip);
                $userCookie = $cookie->id;
            } else if ($userCookie !== null && $userCookie !== null && $userCookie !== 'null' && $userCookie !== 'undefined') {
                if (sizeof($this->trackingCampaignShowS->getByUserCookieId($userCookie)) === 0) {
                    $cookie = $this->userService->createCookieIfNew($ip);
                    $userCookie = $cookie->id;
                }
            }

            //track visit
            $trackingVisit = $this->trackingService->createVisit(null, $userCookie, $url, $articleId);
            //filter campaigns - get users data -read articles
            $readArticles = $this->articleService->getNumberOfArticlesUserCookie($userCookie);
            $userData = new UserData(false, $readArticles);

            $campaigns = $this->campaignRepository->getActiveCampaigns($userData, $url, $author, $category)->toArray();

            //remove show, not valid campaigns
            $trackingCampaignShow = $this->trackingCampaignShowS->getByUserCookieId($userCookie);
        }

        // TODO: FIX THIS .. request of this method is running long time (more than 40 seconds)
        //$campaigns = $this->trackingCampaignShowS->orderByShowedCampaigns($trackingCampaignShow, $campaigns);
        $campaignIds = array_column($campaigns, 'id');
        // remove first campaign from array (not show in base pages)
        $campaignIds = array_diff($campaignIds, [1]);


        $availableWidgets = Widget::get()
            ->where('active', true)
            ->whereIn('campaign_id', $campaignIds)->toArray();

        // order widget by campaign ids (e.g.: if campaign ids = [3,4,2], than widget from campaign 3 are first,
        // than widgets from campaign 4 and 2)
        usort($availableWidgets, (function ($key1, $key2) use ($campaignIds) {
            return (array_search($key1['campaign_id'], $campaignIds) > array_search($key2['campaign_id'], $campaignIds));
        }));

        //get widgets but only one for specific widget_type_id.
        $widgetDistinctType = array();
        $usedWidgetIds = array();
        $usedCampaignIds = array();
        foreach ($availableWidgets as $widget) {
            $alreadyAddedVisited = false;
            // Check if campaign does not have set how often to display
            $targeting = Targeting::where('campaign_id', $widget['campaign_id'])->first();
            $visitingObject = CampaignsVisited::where('user_cookie', $userCookie)->where('campaign_id', $widget['campaign_id'])->first();
            if ($visitingObject === null) {
                $visiting = 0;
                $previousVisit = '2000-01-01 0:00:00';
            } else {
                $visiting = $visitingObject->visits;
                $previousVisit = $visitingObject->updated_at;
            }
            $canShowWidget = true;

            // handle excluded homepage
            if (($url === env('CFT_PORTAL_URL') || $url === env('CFT_PORTAL_URL') . '/') && $targeting->exclude_homepage) {
                $canShowWidget = false;
            }

            if ($targeting->show_session) {
                // IN THIS CASE SESSION MEANS - show once per 24 hours
                if (Carbon::now() < Carbon::createFromFormat('Y-m-d H:i:s', $previousVisit)->addHours(24)) {
                    $canShowWidget = false;
                }
            } else if ($visiting !== 0 && $targeting->show_nth_page_view) {
                $visiting = (int)$visiting + 1;
                if ($visiting % (int)$targeting->nth_page_view_count !== 0) {
                    $canShowWidget = false;
                    // add visiting for this widget (for next counting)
                    $visitingObject->update([
                        'portal_user_id' => empty($portalUserId) ? null : $portalUserId,
                        'visits' => $visiting
                    ]);
                    $alreadyAddedVisited = true;
                }
            } else if ($visiting !== 0 && $targeting->show_nth_page_view_pause) {
                $countPageView = (int)$targeting->nth_page_view_pause_count; // 5
                $visiting = $visiting + 1;
                for ($i = 1; $i <= $visiting; $i++) { // visiting = 15
                    if ($i <= ($countPageView + (int)$targeting->nth_page_view_pause_pause)) { // 6, 7
                        $canShowWidget = false;
                        if ($i === ($countPageView + (int)$targeting->nth_page_view_pause_pause)) {
                            // next iteration can show widget
                            $countPageView = $i + (int)$targeting->nth_page_view_pause_count; // 7 + 5 = 12
                        }
                    }
                }

                // add visiting for this widget if is pause
                if (!$canShowWidget) {
                    $visitingObject->update([
                        'portal_user_id' => empty($portalUserId) ? null : $portalUserId,
                        'visits' => $visiting
                    ]);
                    $alreadyAddedVisited = true;
                }
            }

            if ($canShowWidget && !in_array($widget['widget_type_id'], $usedWidgetIds)) {
                $canStillShowWidget = true;
                // if is popup or fixed widget
                if ($widget['widget_type_id'] === self::POPUP_WIDGET_TYPE_ID || $widget['widget_type_id'] === self::FIXED_WIDGET_TYPE_ID) {
                    // if click on X
                    if ($targeting->popup_fixed_once && $visitingObject->click_on_x) {
                        $canStillShowWidget = false;
                    } else if ((int)$visiting !== 0 && $targeting->popup_fixed_again_after && $visitingObject->click_on_x) {
                        if (!$alreadyAddedVisited) {
                            $visiting = (int)$visiting + 1;
                            if ($visiting % $targeting->popup_fixed_again_after_count !== 0) {
                                $canStillShowWidget = false;
                                $visitingObject->update([
                                    'portal_user_id' => empty($portalUserId) ? null : $portalUserId,
                                    'visits' => $visiting
                                ]);
                                $alreadyAddedVisited = true;
                            }
                        }

                    } else {
                        // if is POPUP -- EVERY 30mins
                        if ($widget['widget_type_id'] === self::POPUP_WIDGET_TYPE_ID) {
                            if ($popupTime !== null) {
                                if (Carbon::createFromFormat('Y-m-d H:i:s', $popupTime) > Carbon::now()) {
                                    $canStillShowWidget = false;
                                }
                            }
                        }
                    }

                }
                if ($canStillShowWidget) {
                    $widget['widget_id'] = $widget['id'];
                    array_push($widgetDistinctType, WidgetResultResource::make($widget));
                    array_push($usedWidgetIds, $widget['widget_type_id']);
                    if (!in_array($widget['campaign_id'], $usedCampaignIds)) {
                        array_push($usedCampaignIds, $widget['campaign_id']);
                    }
                }
            }
        }


        // save/update/don't change tracking_campaign_show depending on widgets and its campaigns, that was selected in previous step
        foreach ($usedCampaignIds as $usedCampaignId) {
            $searchIndex = array_search($usedCampaignId, array_column($campaigns, 'id'));
            if ($searchIndex !== false) {
                if (!empty($campaigns[$searchIndex]['create_new_campaign_show'])) {
                    if (!empty($portalUserId)) {
                        $this->trackingCampaignShowS->createByPortalUserId($portalUserId, $campaigns[$searchIndex]['id'], $userCookie);
                    } else if ($userCookie) {
                        $this->trackingCampaignShowS->createByUserCookieId($userCookie, $campaigns[$searchIndex]['id']);
                    }
                }
                if (!empty($campaigns[$searchIndex]['update_campaign_show'])) {
                    $this->trackingCampaignShowS->updateValidUntil($campaigns[$searchIndex]['update_campaign_show_id']);
                }

                // add visited campaign
                $campaignVisited = CampaignsVisited::where('user_cookie', $userCookie)->where('campaign_id', $usedCampaignId)->first();
                if ($campaignVisited !== null) {
                    // UPDATE
                    $campaignVisited->update([
                        'portal_user_id' => empty($portalUserId) ? null : $portalUserId,
                        'visits' => $campaignVisited->visits + 1
                    ]);
                } else {
                    // CREATE
                    CampaignsVisited::create([
                        'campaign_id' => $usedCampaignId,
                        'user_cookie' => $userCookie,
                        'portal_user_id' => empty($portalUserId) ? null : $portalUserId,
                        'visits' => 1
                    ]);
                }
            }
        }

        $result['widgets'] = $widgetDistinctType;
        //append addition properties to help tracking with user tracking
        $result['tracking_visit_id'] = $trackingVisit->id;
        $result['user_cookie'] = $userCookie;
        return $result;
    }

    public function smartUpdate($id, $active)
    {

        Widget::find($id)->update([
            'active' => $active
        ]);
    }

    public function cloneWidgetsInCampaign(Campaign $campaign, $newCampaign)
    {
        $widgets = $this->getWidgetsByCampaignId($campaign->id);
        // create widgets from old data
        foreach ($widgets as $widget) {

            $newWidget = $widget->replicate();
            $newWidget->campaign_id = $newCampaign->id;

            $newWidget->save();

            // clone all widget settings
            foreach ($widget->widgetSettings as $widgetSetting) {
                $newWidgetSettings = $widgetSetting->replicate();
                // widget settings
                WidgetSettings::create([
                    'widget_id' => $newWidget->id,
                    'desktop' => $newWidgetSettings['desktop'],
                    'tablet' => $newWidgetSettings['tablet'],
                    'mobile' => $newWidgetSettings['mobile']
                ]);
            }

            foreach ($widget->campaignImage as $img) {
                $newImg = $img->replicate();
                $newImg->campaign_id = $newCampaign->id;
                $newImg->widget_id = $newWidget->id;
                $newImg->save();
            }

            $newWidgetResult = $widget->widgetResults->replicate();
            $newWidgetResult->widget_id = $newWidget->id;
            $newWidgetResult->save();
        }
    }

    //get 'sibling' landing widget if campaign, where is widget has active landing widget
    private function getLandingOfCampaignContainingWidget($widgetId)
    {
        $widgetId = 12;
        return Widget::query()->whereHas('campaign', function ($q) use ($widgetId) {
            $q->whereHas('widget', function ($q2) use ($widgetId) {
                $q2->where('id', $widgetId);
            });
        })->where('widget_type_id', 1)
            ->where('active', true)
            ->first();

    }

}
