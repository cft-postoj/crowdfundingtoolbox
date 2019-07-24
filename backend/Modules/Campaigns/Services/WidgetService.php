<?php

namespace Modules\Campaigns\Services;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignImage;
use Modules\Campaigns\Entities\CampaignsConfiguration;
use Modules\Campaigns\Entities\DeviceType;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Campaigns\Entities\WidgetVersion;
use Modules\Campaigns\Http\Controllers\WidgetTypesController;
use Modules\Campaigns\Transformers\WidgetResource;
use Modules\Campaigns\Transformers\WidgetResultResource;
use Modules\Campaigns\WidgetTypesResources\ArticleWidget;
use Modules\Campaigns\WidgetTypesResources\FixedWidget;
use Modules\Campaigns\WidgetTypesResources\LeaderboardWidget;
use Modules\Campaigns\WidgetTypesResources\LockedArticleWidget;
use Modules\Campaigns\WidgetTypesResources\PopupWidget;
use Modules\Campaigns\WidgetTypesResources\SidebarWidget;
use Modules\UserManagement\Services\TrackingService;
use Modules\UserManagement\Services\UserService;

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

    public function __construct()
    {
        $this->trackingService = new TrackingService();
        $this->userService = new UserService();
        $this->sidebarWidget = new SidebarWidget();
        $this->fixedWidget = new FixedWidget();
        $this->popupWidget = new PopupWidget();
        $this->leaderboardWidget = new LeaderboardWidget();
        $this->lockedArticleWidget = new LockedArticleWidget();
        $this->articleWidget = new ArticleWidget();
    }

    public function createWidgetsForCampaign($campaignId)
    {
        $result = array();
        try {
            $widgetIds = WidgetTypesController::getWidgetTypeIds();

            foreach ($widgetIds as $id) {
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

                $widget->settings = WidgetSettings::create([
                    'widget_id' => $widget->id,
                    'desktop' => $this->overrideMonetization(DeviceType::find(1), $widgetSettingsDesktop, $id),
                    'tablet' => $this->overrideMonetization(DeviceType::find(2), $widgetSettingsTablet, $id),
                    'mobile' => $this->overrideMonetization(DeviceType::find(3), $widgetSettingsMobile, $id)
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

        WidgetSettings::where('widget_id', $id)->update([
            'desktop' => json_encode($rawWidgetData['settings']['desktop']),
            'tablet' => json_encode($rawWidgetData['settings']['tablet']),
            'mobile' => json_encode($rawWidgetData['settings']['mobile'])
        ]);
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

    public function createSettingsJson($widgetType, $deviceType)
    {
        $this->widgetSettings = $this->widgetSettingsStructure();
        $this->paymentSettings = $this->paymentSettingsStructure($widgetType);
        // GET GENERAL CAMPAIGN SETTINGS
        $generalSettings = $this->getGeneralSettings();
        $generalWidgetSettings = json_decode($generalSettings['widget_settings'], true);
        $generalSettingsHeadlineText = json_decode($generalSettings['font_settings_headline_text'], true);
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
            'type' => 'color',
            'image' => array('id' => 0, 'url' => null),
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


        $result = array(
            'headline_text' => $generalWidgetSettings['headline_text']['text'],
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

        $overridedSettings['payment_settings']['design']['padding']['top'] = '5px';
        $overridedSettings['payment_settings']['design']['padding']['right'] = '5px';
        $overridedSettings['payment_settings']['design']['padding']['bottom'] = '5px';
        $overridedSettings['payment_settings']['design']['padding']['left'] = '5px';


        $overridedSettings['payment_settings']['design']['margin']['top'] = '5px';
        $overridedSettings['payment_settings']['design']['margin']['right'] = '5px';
        $overridedSettings['payment_settings']['design']['margin']['bottom'] = '5px';
        $overridedSettings['payment_settings']['design']['margin']['left'] = '5px';

        // Landing Page Widget
        if ($widgetTypeId == 1):
            switch ($typeId) {
                case 1: // desktop
                    $overridedSettings['payment_settings']['design']['width'] = '40%';
                    $overridedSettings['payment_settings']['design']['padding']['top'] = '15px';
                    $overridedSettings['payment_settings']['design']['padding']['right'] = '30px';
                    $overridedSettings['payment_settings']['design']['padding']['bottom'] = '15px';
                    $overridedSettings['payment_settings']['design']['padding']['left'] = '30px';
                    $overridedSettings['payment_settings']['design']['shadow']['opacity'] = 1;
                    $overridedSettings['additional_settings']['buttonContainer']['position'] = 'relative';
                    $overridedSettings['additional_settings']['buttonContainer']['textAlign'] = 'center';
                    break;
                case 2: // tablet

                    break;
                case 3: // mobile

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

    public function paymentSettingsStructure($widgetTypeId)
    {
        $structure = array(
            'active' => ($widgetTypeId == 1) ? true : false,
            'payment_type' => 'both',
            'type' => 'classic',
            'monetization_title' => array(
                'text' => 'We can write of <br/> your financial support!',
                'textColor' => '#000000',
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
                'text_color' => '#777777',
                'shadow' => array(
                    'color' => '#77777',
                    'opacity' => 0,
                    'x' => 3,
                    'y' => 3,
                    'b' => 3
                )
            ),
            'monthly_prices' => array(
                'custom_price' => false,
                'count_of_options' => 2,
                'options' => array(
                    array(
                        'value' => 30
                    ),
                    array(
                        'value' => 40
                    )
                ),
                'benefit' => array(
                    'active' => true,
                    'text' => '',
                    'value' => 10
                )
            ),
            'once_prices' => array(
                'custom_price' => false,
                'count_of_options' => 2,
                'options' => array(
                    array(
                        'value' => 30
                    ),
                    array(
                        'value' => 40
                    )
                ),
                'benefit' => array(
                    'active' => true,
                    'active' => true,
                    'text' => '',
                    'value' => 10
                )
            ),
            'default_price' => array(
                'active' => true,
                'value' => 30,
                'styles' => array(
                    'background' => "#0087ed",
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
            'terms' => array(
                'text' => 'I agree to processing of personal data and receiving newsletters'
            )
        );
        return $structure;
    }

    public function getAdditionalWidgetSettings($widgetType, $generalSettings, $deviceType)
    {
        $outputJson = array();
        switch ($widgetType) {
            case 1: // landing widget
                $outputJson = array(
                    'width' => '100%',
                    'height' => '100%',
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
                        'position' => 'absolute',
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

    /**
     * @return array
     */
    public function getWidgets($url, $title, $userCookie, $userId, $ip)
    {
        $actualDate = date('Y-m-d');
        $campaignIds = Campaign::all()
            ->where('active', true)
            ->where('promote.start_date_value', '<=', $actualDate)
            ->pluck('id');
        $randomResponse =
            Widget::inRandomOrder()
                ->get()
                ->where('active', true)
                ->whereIn('campaign_id', $campaignIds)
                ->whereIn('widget_type_id', [2, 3, 4, 5, 6]);
        $onlyThreeWidgets = array();
        $usedWidgetIds = array();
        $user = Auth::user();
        $userId = $user != null ? $user->id : null;
        $newCookie = $this->userService->createCookieIfNew($userCookie, $userId, $ip);
        if ($newCookie != null) {
            $userCookie = $newCookie->id;
        }
        // get domain name from $url (third character /)
        $articleId = '';
        if ($url !== null) {
            $articleId = explode('/', explode(explode('/', $url)[2], $url)[1])[0];
        } else {
            $url = '127.0.0.1:8001';
        }

        $trackingVisit = $this->trackingService->createVisit($userId, $userCookie, $url, $title, $articleId);
        foreach ($randomResponse as $rand) {
            if (!in_array($rand['widget_type_id'], $usedWidgetIds)) {
                $trackingShow = $this->trackingService->show($trackingVisit->id, $rand['widget_type_id']);
                $rand['show_id'] = $trackingShow->id;
                array_push($onlyThreeWidgets, WidgetResultResource::make($rand));
                array_push($usedWidgetIds, $rand['widget_type_id']);
            }
        }
        $result['widgets'] = $onlyThreeWidgets;
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
            $newWidgetSettings = $widget->widgetSettings->replicate();
            $newWidgetSettings->widget_id = $newWidget->id;

            foreach ($widget->campaignImage as $img) {
                $newImg = $img->replicate();
                $newImg->campaign_id = $newCampaign->id;
                $newImg->widget_id = $newWidget->id;
                $newImg->save();
            }
        }
    }
}