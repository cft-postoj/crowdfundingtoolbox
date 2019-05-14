<?php

namespace Modules\Campaigns\Http\Controllers;

use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignImage;
use Modules\Campaigns\Entities\CampaignsConfiguration;
use Modules\Campaigns\Entities\CampaignSettings;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Campaigns\Entities\WidgetVersion;
use Modules\Campaigns\Http\Controllers\WidgetTypesController;
use Modules\Campaigns\Transformers\WidgetResource;
use Modules\Campaigns\Transformers\WidgetResultResource;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WidgetsController extends Controller
{
    private $widgetIds = array();
    private $campaignId;
    private $widgetSettings;
    private $widgetVersionService;

    public function __construct()
    {
        $this->widgetSettings = array();
    }


    public function updateWidgetSettingsFromCampaign($campaignId, $headlineText, $paymentSettings, $promoteSettings, $widgetSettings)
    {
        try {
            $widgets = Widget::all()->where('campaign_id', $campaignId);
            foreach ($widgets as $w) {
                // if use_campaign_settings == true --> use campaign settings in update campaign
                if ($w->use_campaign_settings) {
                    $widgetId = $w->id;
                    $settings = json_encode($this->createSettingsJson($headlineText, $widgetSettings, $promoteSettings, $paymentSettings, $w->widget_type_id));
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

    /**
     * @OA\Get(
     *     path="/api/backoffice/widgets/{id}/settings-from-campaign",
     *     tags={"WIDGETS"},
     *     summary="Get settings to updated widget from campaign",
     *     description="Only for authenticated users.",
     *     operationId="settingsFromCampaignByWidgetId",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Widget id",
     *     required=true,
     *     schema = {
     *        "type": "number"
     *     }
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Success!")
     * )
     */
    protected function updateSettingsFromCampaign($id)
    {
        try {
            $oldSettings = WidgetSettings::where('widget_id', $id)->first();
            $campaignId = Widget::find($id)->campaign_id;

            $editedSettingsDesktop = json_decode($oldSettings->desktop, true);
            $editedSettingsTablet = json_decode($oldSettings->tablet, true);
            $editedSettingsMobile = json_decode($oldSettings->mobile, true);
            $editedSettingsDesktop = array(
                'email_settings' => $editedSettingsDesktop['email_settings'],
                'additional_text' => $editedSettingsDesktop['additional_text'],
                'cta' => $editedSettingsDesktop['cta']
            );
            $editedSettingsTablet = array(
                'email_settings' => $editedSettingsTablet['email_settings'],
                'additional_text' => $editedSettingsTablet['additional_text'],
                'cta' => $editedSettingsTablet['cta']
            );
            $editedSettingsMobile = array(
                'email_settings' => $editedSettingsMobile['email_settings'],
                'additional_text' => $editedSettingsMobile['additional_text'],
                'cta' => $editedSettingsMobile['cta']
            );

            $campaignSettings = $this->initialWidgetSettings($campaignId);
            $campaignSettings['email_settings'] = $editedSettingsDesktop['email_settings'];
            $campaignSettings['additional_text'] = $editedSettingsDesktop['additional_text'];
            $campaignSettings['cta'] = $editedSettingsDesktop['cta'];
            $editedSettingsDesktop = $campaignSettings;
            $campaignSettings['email_settings'] = $editedSettingsTablet['email_settings'];
            $campaignSettings['additional_text'] = $editedSettingsTablet['additional_text'];
            $campaignSettings['cta'] = $editedSettingsTablet['cta'];
            $editedSettingsTablet = $campaignSettings;
            $campaignSettings['email_settings'] = $editedSettingsMobile['email_settings'];
            $campaignSettings['additional_text'] = $editedSettingsMobile['additional_text'];
            $campaignSettings['cta'] = $editedSettingsMobile['cta'];
            $editedSettingsMobile = $campaignSettings;


            WidgetSettings::where('widget_id', $id)->update([
                'desktop' => json_encode($editedSettingsDesktop),
                'tablet' => json_encode($editedSettingsTablet),
                'mobile' => json_encode($editedSettingsMobile)
            ]);

        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Successfully added campaign settings to actual widget.'
        ], Response::HTTP_OK);
    }

    private function initialWidgetSettings($id, $widgetType)
    {
        $campaignSettingsData = CampaignSettings::where('campaign_id', $id)->first();
        $campaignWidgetSettings = json_decode($campaignSettingsData->widget_settings, true);
        $promoteWidgetSettings = json_decode($campaignSettingsData->promote_settings, true);
        $paymentSettings = json_decode($campaignSettingsData->payment_settings, true);

        $campaignData = Campaign::find($id);


        return $this->createSettingsJson($campaignData->headline_text, $campaignWidgetSettings, $promoteWidgetSettings, $paymentSettings, $widgetType);
    }

    private function createSettingsJson($headlineText, $widgetSettings, $promoteSettings, $paymentSettings, $widgetType)
    {

        // GET GENERAL CAMPAIGN SETTINGS
        $generalSettings = $this->getGeneralSettings();
        $generalWidgetSettings = json_decode($generalSettings['widget_settings'], true);
        $generalSettingsHeadlineText = json_decode($generalSettings['font_settings_headline_text'], true);
        $generalCtaSettings = json_decode($generalSettings['cta'], true);

        $widgetSettings['general']['fontSettings'] = $this->overrideGeneralSettings('headlineFonts', array(
            'fontFamily' => $generalSettingsHeadlineText['fontFamily'],
            'fontWeight' => $generalSettingsHeadlineText['fontWeight'],
            'alignment' => 'center',
            'color' => $generalSettingsHeadlineText['color'],
            'backgroundColor' => $generalSettingsHeadlineText['backgroundColor'],
            'fontSize' => $generalSettingsHeadlineText['fontSize']
        ), $widgetType);

        $widgetSettings['general']['background'] = array(
            'type' => 'color',
            'image' => array('id' => 0, 'url' => null),
            'color' => $generalWidgetSettings['backgroundColor'],
            'opacity' => 100
        );

        $widgetSettings['general']['text_margin'] = $this->overrideGeneralSettings('headlineMargin', $widgetSettings['general']['text_margin'], $widgetType);

        $widgetSettings['call_to_action'] = $this->overrideGeneralSettings('cta', $generalCtaSettings, $widgetType);

        // Additional text
        $widgetSettings['additional_text'] = array(
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


        $this->widgetSettings = array(
            'headline_text' => $generalWidgetSettings['headline_text']['text'],
            'widget_settings' => $widgetSettings,
            'promote_settings' => $promoteSettings,
            'payment_settings' => $paymentSettings,
            'email_settings' => array(
                'active' => false,
                'subscribe_text' => ''
            ),
            'cta' => array(
                'text' => $generalWidgetSettings['cta']['text'],
                'url' => $generalWidgetSettings['cta']['url']
            ),
            'additional_settings' =>
                $this->getAdditionalWidgetSettings($widgetType, $generalSettings)

        );
        return $this->widgetSettings;
    }

    private function overrideGeneralSettings($type, $settings, $widgetType)
    {
        $output = $settings;
        if ($type == 'cta') {
            switch ($widgetType) {
                case 1: // landing widget
                    $output = $settings;
                    break;
                case 2: // sidebar widget
                    $output = $settings;
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
                    $output['fontSize'] =  50;
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

    protected function getGeneralSettings()
    {
        return CampaignsConfiguration::where('id', 1)->get()[0];
    }

    private function create()
    {
        try {
            $this->widgetIds = WidgetTypesController::getWidgetTypeIds();
            foreach ($this->widgetIds as $id) {
                $widgetSettings = json_encode($this->initialWidgetSettings($this->campaignId, $id));
                $paymentType = ($id == 1) ? true : false;
                $widget = Widget::create([
                    'campaign_id' => $this->campaignId,
                    'widget_type_id' => $id,
                    'active' => false,
                    'payment_type' => $paymentType
                ]);
                $widget->save();
                WidgetSettings::create([
                    'widget_id' => $widget->id,
                    'desktop' => $widgetSettings,
                    'tablet' => $widgetSettings,
                    'mobile' => $widgetSettings
                ]);
                // create Widget results
                WidgetResult::create([
                    'widget_id' => $widget->id,
                    'campaign_id' => $this->campaignId,
                    'widget_type_id' => $id,
                    'desktop' => '<div></div>',
                    'tablet' => '<div></div>',
                    'mobile' => '<div></div>'
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }

        return response()->json([
            'message' => 'Successfully created widgets!'
        ], Response::HTTP_CREATED);
    }

    private function getAdditionalWidgetSettings($widgetType, $generalSettings)
    {
        $outputJson = array();
        switch ($widgetType) {
            case 1: // landing widget
                $outputJson = array();
                break;
            case 2: // sidebar widget
                $outputJson = array(
                    'width' => '300px',
                    'maxWidth' => '100%',
                    'height' => '600px',
                    'position' => 'relative',
                    'fixedSettings' => array(),
                    'display' => 'block',
                    'bodyContainer' => array(
                        'width' => '100%',
                        'height' => '100%',
                        'margin' => '0 auto',
                        'position' => 'relative',
                        'top' => 'auto',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'text' => array(
                            'width' => '100%',
                            'top' => '30px'
                        )
                    ),
                    'textContainer' => array(
                        'width' => '100%',
                        'height' => '100%',
                        'margin' => '0 auto',
                        'position' => 'relative',
                        'top' => 'auto',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'text' => array(
                            'width' => '100%',
                            'top' => '30px',
                            'textAlign' => 'left'
                        )
                    ),
                    'buttonContainer' => array(
                        'width' => '100%',
                        'position' => 'absolute',
                        'top' => 'auto',
                        'right' => 'auto',
                        'bottom' => '50px',
                        'left' => 'auto',
                        'display' => 'block',
                        'textAlign' => 'center',
                        'margin' => array(
                            'top' => '420',
                            'right' => 'auto',
                            'bottom' => '0',
                            'left' => 'auto'
                        ),
                        'button' => array(
                            'width' => '100%',
                            'padding' => array(
                                'top' => '15',
                                'right' => '70',
                                'bottom' => '20',
                                'left' => '70'
                            )
                        )
                    )
                );
                break;
            case 3: // leaderboard
                $outputJson = array(
                    'width' => '100%',
                    'height' => '350px',
                    'position' => 'relative',
                    'fixedSettings' => array(),
                    'display' => 'block',
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
            case 4: // popup
                $outputJson = array();
                break;
            case 5: // fixed widget
                $outputJson = array(
                    'width' => '100%',
                    'maxWidth' => '100%',
                    'height' => '80px',
                    'position' => 'fixed',
                    'fixedSettings' => array(
                        'top' => 'auto',
                        'bottom' => '0',
                        'zIndex' => 999999,
                        'textAlign' => 'center'
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
                        'top' => 'auto',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'text' => array(
                            'width' => '100%',
                            'maxWidth' => '100%'
                        )),
                    'display' => 'inline-block',
                    'textContainer' => array(
                        'width' => 70,
                        'margin' => array(
                            'top' => '0',
                            'right' => 'auto',
                            'bottom' => '0',
                            'left' => 'auto'
                        ),
                        'position' => 'absolute',
                        'top' => 'auto',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'text' => array(
                            'width' => '100%',
                            'maxWidth' => '100%'
                        )
                    ),
                    'buttonContainer' => array(
                        'width' => 30,
                        'position' => 'relative',
                        'top' => 'auto',
                        'right' => 'auto',
                        'bottom' => 'auto',
                        'left' => 'auto',
                        'button' => array(
                            'width' => '300px',
                            'maxWidth' => '100%'
                        )
                    )
                );
                break;
            case 6: // locked article
                $outputJson = array();
                break;
            case 7: // article widget
                $outputJson = array();
                break;
            case 8: // article link
                $outputJson = array();
                break;
            case 9: // custom html + css
                $outputJson = array();
                break;
            default:
                break;
        }
        return $outputJson;
    }

    public
    function createWidgets($id)
    {
        $this->campaignId = $id;
        return $this->create();
    }


    protected
    function delete(Request $request)
    {
        // No delete action - remove can be only campaign with all widgets
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/widgets/{id}",
     *     tags={"WIDGETS"},
     *     summary="Get widget by id",
     *     description="Only for authenticated users.",
     *     operationId="getWidgetById",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Widget id",
     *     required=true,
     *     schema = {
     *        "type": "number"
     *     }
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Success!")
     * )
     */
    protected
    function show($id)
    {
        try {
            if (Widget::find($id) == null) {
                return \response()->json([
                    'error' => 'Widget is not exist.'
                ], Response::HTTP_BAD_REQUEST);
            }
            return WidgetResource::make(Widget::find($id));
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/campaigns/{id}/widgets",
     *     tags={"WIDGETS"},
     *     summary="Get all widgets by campaign id",
     *     description="Only for authenticated users.",
     *     operationId="getWidgetsByCampaignId",
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Campaing id",
     *     required=true,
     *     schema = {
     *        "type": "number"
     *     }
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Success!")
     * )
     */
    protected
    function getWidgetsByCampaignId($campaignId)
        // At the moment, only for these types of widgets: Sidebar, Fixed and Leaderboard
    {
        try {
            //return WidgetResource::collection(Widget::all()->where('campaign_id', $campaignId));
            return WidgetResource::collection(Widget::orderBy('active', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get()
                ->where('campaign_id', $campaignId)
                ->whereIn('widget_type_id', [1, 2, 3, 5])); // landing, sidebar, leaderboard, fixed
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/backoffice/widgets/{id}",
     *     tags={"WIDGETS"},
     *     summary="Update specific widget by id",
     *     description="Only for authenticated users.",
     *     operationId="getWidgetsByCampaignId",
     *     @OA\JsonContent(),
     *     @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Widget id",
     *     required=true,
     *     schema = {
     *        "type": "number"
     *     }
     * ),
     *
     *     @OA\RequestBody(
     *      description="JSON for updating existed campaign. This endpoint is for request with one parameter (active, date_from or date_to). If you add more parameters, it will be processed only first of these.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="active", type="boolean"
     *           ),
     *          @OA\Property(
     *              property="settings", type="json"
     *           ),
     *          example={
     *              "active": true,"settings": {"desktop": "...", "tablet": "...", "mobile": "..."}}
     *
     *       )),
     *
     *
     *     @OA\Response(
     *         response=201,
     *         description="Success!")
     * )
     */
    protected
    function update(Request $request, $id)
    {
        $valid = $this->validateRequest($request);
        if ($valid['status'] != 'ok') {
            return \response()->json([
                $valid
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $paymentType = (Widget::find($id)->where('widget_type_id', 1)->first() != null) ? true :
                $request['payment_type'];
            Widget::find($id)->update([
                'active' => $request['active'],
                'use_campaign_settings' => false,
                'payment_type' => $paymentType
            ]);

            WidgetSettings::where('widget_id', $id)->update([
                'desktop' => json_encode($request['settings']['desktop']),
                'tablet' => json_encode($request['settings']['tablet']),
                'mobile' => json_encode($request['settings']['mobile'])
            ]);

            if (CampaignImage::where('widget_id', $id)->first() == null &&
                $request['settings']['desktop']['widget_settings']['general']['background']['image']['url'] != null) {
                // create image mapping
                CampaignImage::create([
                    'campaign_id' => Widget::find($id)->only('campaign_id')['campaign_id'],
                    'widget_id' => $id,
                    'image_id' => $request['settings']['desktop']['widget_settings']['general']['background']['image']['id'],
                    'device_type' => 1 //desktop
                ]);
                CampaignImage::create([
                    'campaign_id' => Widget::find($id)->only('campaign_id')['campaign_id'],
                    'widget_id' => $id,
                    'image_id' => $request['settings']['tablet']['widget_settings']['general']['background']['image']['id'],
                    'device_type' => 2 //tablet
                ]);
                CampaignImage::create([
                    'campaign_id' => Widget::find($id)->only('campaign_id')['campaign_id'],
                    'widget_id' => $id,
                    'image_id' => $request['settings']['mobile']['widget_settings']['general']['background']['image']['id'],
                    'device_type' => 3 //mobile
                ]);
            } else {
                // update image mapping
                CampaignImage::where('widget_id', $id)->where('device_type', 1)->update([
                    'image_id' => $request['settings']['desktop']['widget_settings']['general']['background']['image']['id']
                ]);
                CampaignImage::where('widget_id', $id)->where('device_type', 2)->update([
                    'image_id' => $request['settings']['tablet']['widget_settings']['general']['background']['image']['id']
                ]);
                CampaignImage::where('widget_id', $id)->where('device_type', 3)->update([
                    'image_id' => $request['settings']['mobile']['widget_settings']['general']['background']['image']['id']
                ]);
            }


            $user = Auth::user();
            $this->addTracking($id, $user->id, $this->show($id));

        } catch (\Exception $e) {
            return \response()->json([
                'error' => 'There was a problem with widget updating.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Widget was successfully updated.'
        ], Response::HTTP_CREATED);
    }

    private
    function addTracking($widgetId, $userId, $data)
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

    private
    function validateRequest($request)
    {
        $valid = Validator::make($request->all(), [
            'active' => 'required|boolean',
            'settings' => 'required|array',
            'settings.desktop' => 'required|array',
            'settings.tablet' => 'required|array',
            'settings.mobile' => 'required|array'
        ]);
        if ($valid->fails()) {
            return array(
                'status' => 'error',
                'message' => 'Wrong shape of requested JSON object',
                'errors' => $valid->errors()
            );
        }
        return array(
            'status' => 'ok'
        );
    }



    /**
     * @OA\Get(
     *     path="/api/portal/widgets",
     *     tags={"PORTAL CONNECTION"},
     *     summary="Get all active widgets",
     *     description="Get random type of widget from every active campaign.",
     *     operationId="getPortalWidgets",
     *     @OA\Response(
     *         response=200,
     *         description="Success!")
     * )
     */
    /*
     * GET widgets from all types - FOR PORTAL SIDE
     */
    protected function getWidgets()
    {
        try {
            $actualDate = date('Y-m-d');
            $campaignIds = Campaign::all()
                ->where('active', true)
                ->where('date_to', '>=', $actualDate)
                ->pluck('id');
            $randomResponse =
                Widget::inRandomOrder()
                    ->get()
                    ->where('active', true)
                    ->whereIn('campaign_id', $campaignIds)
                    ->whereIn('widget_type_id', [2, 3, 5]); // get only widget sidebar, leaderboard and fixed
            $onlyThreeWidgets = array();
            $usedWidgetIds = array();
            foreach ($randomResponse as $rand) {
                if (!in_array($rand['widget_type_id'], $usedWidgetIds)) {
                    array_push($onlyThreeWidgets, WidgetResultResource::make($rand));
                    array_push($usedWidgetIds, $rand['widget_type_id']);
                }
            }
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }


        return $onlyThreeWidgets;
    }

    /**
     * @OA\Put(
     *     path="/api/backoffice/widgets/:id/result",
     *     tags={"WIDGETS"},
     *     summary="Update HTML result for specific widget by widget id.",
     *     description="Only for authenticated users.",
     *     operationId="updateWidgetResult",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated result!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="",
     *         @OA\JsonContent(
     *           type="object",
     *          @OA\Property(
     *              property="desktop", type="string"
     *           ),
     *          @OA\Property(
     *              property="tablet", type="string"
     *          ),
     *          @OA\Property(
     *              property="mobile", type="string"
     *          ),
     *          example={
     *              "desktop":"<div>example</div>", "tablet":"<div>example</div>", "mobile":"<div>example</div>"}
     *
     *       ),
     *
     * )
     * )
     */
    protected function updateResult(Request $request, $id)
    {
        try {
            $widgetResults = WidgetResult::all()
                ->where('widget_id', $id);
            foreach ($widgetResults as $result) {
                WidgetResult::find($result['id'])->update([
                    'desktop' => $request['desktop'],
                    'tablet' => $request['tablet'],
                    'mobile' => $request['mobile']
                ]);
            }
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
        return \response()->json([
            'message' => 'Successfully updated widget HTML results.'
        ], Response::HTTP_OK);

    }

    /**
     * @OA\Put(
     *     path="/api/backoffice/widgets/:id/smart-settings",
     *     tags={"WIDGETS"},
     *     summary="Smart update widget by widget id",
     *     description="Only for authenticated users.",
     *     operationId="smartUpdateWidget",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated widget!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="JSON for updating existed widget. This endpoint is for request with one parameter - only ACTIVE.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="active", type="boolean"
     *           ),
     *          example={
     *              "active": true}
     *
     *       ),
     *
     * )
     * )
     */
    protected function smartWidgetUpdate(Request $request, $id)
    {
        $valid = validator($request->only('active'), [
            'active' => 'required|boolean'
        ]);
        if ($valid->fails()) {
            return response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            Widget::where('id', $id)->update([
                'active' => $request['active']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'message' => 'Wrong request format.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated widget with id ' . $id . '!'
        ], Response::HTTP_CREATED);
    }
}
