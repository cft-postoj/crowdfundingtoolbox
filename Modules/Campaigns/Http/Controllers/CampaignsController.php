<?php

namespace Modules\Campaigns\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignImage;
use Modules\Campaigns\Entities\CampaignSettings;
use Modules\Campaigns\Entities\CampaignVersion;
use Modules\Campaigns\Entities\DeviceType;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Campaigns\Transformers\CampaignResource;
use Modules\Campaigns\Transformers\CampaignResourceDetail;
use Modules\Campaigns\Transformers\WidgetResource;
use App\Http\Services\TargetingService;
use App\Http\Controllers\API\UserService;
use Illuminate\Support\Facades\Auth;

class CampaignsController extends Controller
{
    private $user;
    private $widgetsController;
    private $campaignId;
    private $targetingService;

    public function __construct()
    {
        $this->user = new UserService();
        $this->widgetsController = new WidgetsController();
        $this->targetingService = new TargetingService();
    }

    /**
     * @OA\Post(
     *     path="/api/backoffice/campaigns",
     *     tags={"CAMPAIGNS"},
     *     summary="Create campaign",
     *     description="Only for authenticated users.",
     *     operationId="createCampaign",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully created campaign!",
     *     @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *      description="After created campaign, it will be activated.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="name", type="string"
     *           ),
     *            @OA\Property(
     *              property="date_from", type="date"
     *           ),
     *          @OA\Property(
     *              property="date_to", type="date"
     *          ),
     *          @OA\Property(
     *              property="description", type="null"
     *          ),
     *          @OA\Property(
     *              property="headline_text", type="null"
     *          ),
     *          example={
     *              "name": "Test Campaign",
     *              "date_from": "02.05.2019",
     *              "date_to": "02.06.2019",
     *              "description": "",
     *              "headline_text": ""}
     *
     *       )
     *
     * )
     * )
     */
    protected function create(Request $request)
    {
        $valid = validator($request->only('active', 'name', 'date_from', 'date_to', 'payment_settings', 'promote_settings', 'widget_settings'), [
            'active' => 'required|boolean',
            'name' => 'required|string',
            'date_from' => 'required|string',
            'date_to' => 'required|string',
            'payment_settings' => 'required|array',
            'promote_settings' => 'required|array',
            'widget_settings' => 'required|array'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $campaign = Campaign::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'headline_text' => $request['headline_text'],
            'active' => $request['active'],
            'date_from' => $request['date_from'],
            'date_to' => $request['date_to']
        ]);

        $campaign->save();
        $this->campaignId = $campaign->id;

        $this->campaignSettings($this->campaignId, $request['payment_settings'], $request['promote_settings'], $request['widget_settings']);

        $this->targetingService->createTargetingFromRequest($this->campaignId, $request['targeting']);

        $this->widgetsController->createWidgets($campaign->id);

        $user = Auth::user();

        $this->addTracking($campaign->id, $user->id, $this->show($campaign->id));


        return response()->json([
            'message' => 'Successfully created campaign!',
            'campaign_id' => $campaign->id,
            'widgets' => WidgetResource::collection(Widget::all()->where('campaign_id', $campaign->id)->whereIn('widget_type_id', [2, 3, 5]))
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/backoffice/campaigns/:id",
     *     tags={"CAMPAIGNS"},
     *     summary="Update campaign by campaign id",
     *     description="Only for authenticated users.",
     *     operationId="updateCampaign",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated campaign!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="JSON for updating existed campaign.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="active", type="boolean"
     *           ),
     *           @OA\Property(
     *              property="name", type="string"
     *           ),
     *            @OA\Property(
     *              property="date_from", type="date"
     *           ),
     *          @OA\Property(
     *              property="date_to", type="date"
     *          ),
     *          @OA\Property(
     *              property="description", type="null"
     *          ),
     *          @OA\Property(
     *              property="headline_text", type="null"
     *          ),
     *          @OA\Property(
     *              property="payment_settings", type="json"
     *          ),
     *          @OA\Property(
     *              property="widget_settings", type="json"
     *          ),
     *          example={
     *              "active": false,
     *              "name": "Test Campaign",
     *              "date_from": "02.05.2019",
     *              "date_to": "02.06.2019",
     *              "description": "Test decripiton",
     *              "headline_text": "Test headline",
     *              "payment_settings": {
    "payment_type": "both",
    "monthly_prices": {
    "count_of_options": 2,
    "options": {
    "no1": 30,
    "no2": 20
    }
    },
    "once_prices": {
    "count_of_options": 2,
    "options": {
    "no1": 30,
    "no2": 20
    }
    },
    "default_price": {
    "active": true,
    "styles": {
    "background": "#3B3232",
    "color": "#FFFFFF"
    }
    }
    },
     *              "widget_settings": {
    "general": {
    "fontSettings": {
    "fontFamily": "Roboto",
    "fontWeight": "Bold",
    "aligment": "center",
    "color": "#FFFFFF",
    "fontSize": 24
    },
    "background": {
    "type": "image-overlay",
    "image": {
    "id": 7,
    "url": "http://localhost/crowdfundingToolbox/y-7BW-Snímka obrazovky 2019-01-23 o 20.11.46.png"
    },
    "color": "#1F4F7B",
    "opacity": "33"
    },
    "common_text": "Lorem ipsum bla bla"
    },
    "callToAction": {
    "default": {
    "padding": {
    "top": "10",
    "right": "25",
    "bottom": "10",
    "left": "25"
    },
    "margin": {
    "top": "0",
    "right": "auto",
    "bottom": "0",
    "left": "auto"
    },
    "fontSettings": {
    "fontFamily": "Roboto",
    "fontWeight": "Bold",
    "aligment": "center",
    "color": "#FFFFFF",
    "fontSize": 24
    },
    "design": {
    "fill": {
    "active": true,
    "color": "#B71100",
    "opacity": 100
    },
    "border": {
    "active": false,
    "color": "#B71100",
    "size": 2,
    "opacity": 0
    },
    "shadow": {
    "active": false,
    "x": 2,
    "y": 2,
    "b": 2,
    "opacity": 15
    }

    }
    },
    "hover": {
    "type": "fade",
    "fontSettings": {
    "fontWeight": "bold",
    "color": "#FFFFFF"
    },
    "design": {
    "fill": {
    "active": true,
    "color": "#B71100",
    "opacity": 100
    },
    "border": {
    "active": false,
    "color": "#B71100",
    "size": 2,
    "opacity": 0
    },
    "shadow": {
    "active": false,
    "x": 2,
    "y": 2,
    "b": 2,
    "opacity": 15
    }

    }
    }
    }
    }
     *     }
     *
     *       ),
     *
     * )
     * )
     */
    protected function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'active', 'date_from', 'date_to', 'payment_settings', 'promote_settings', 'widget_settings'), [
            'name' => 'required|string',
            'active' => 'required|boolean',
            'date_from' => 'required|string',
            'date_to' => 'required|string',
            'payment_settings' => 'required|array',
            'promote_settings' => 'required|array',
            'widget_settings' => 'required|array'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        if ($id == null) {
            $jsonError = response()->json([
                'error' => 'Campaign id is required.'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        if (Campaign::find($id) == null) {
            $jsonError = response()->json([
                'error' => 'Wrong campaign ID.'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        Campaign::find($id)->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'headline_text' => $request['headline_text'],
            'active' => $request['active'],
            'date_from' => $request['date_from'],
            'date_to' => $request['date_to']
        ]);

        $this->campaignSettings($id, $request['payment_settings'], $request['promote_settings'], $request['widget_settings']);

        $this->widgetsController->updateWidgetSettingsFromCampaign($id, $request['headline_text'], $request['payment_settings'], $request['promote_settings'], $request['widget_settings']);

        $this->targetingService->updateTargetingFromRequest($id, $request['targeting']);

        $user = Auth::user();

        $this->addTracking($id, $user->id, $this->show($id));


        return response()->json([
            'message' => 'Successfully updated campaign with id ' . $id . '!',
            'campaign_id' => $id,
            'widgets' => WidgetResource::collection(Widget::all()->where('campaign_id', $id)->whereIn('widget_type_id', [2, 3, 5]))
        ], Response::HTTP_CREATED);
    }


    /**
     * @OA\Put(
     *     path="/api/backoffice/campaigns/:id/smart-settings",
     *     tags={"CAMPAIGNS"},
     *     summary="Smart update campaign by campaign id",
     *     description="Only for authenticated users.",
     *     operationId="smartUpdateCampaign",
     *     @OA\Response(
     *         response=201,
     *         description="Successfully updated campaign!",
     *     @OA\JsonContent()
     *     ),
     *
     *     @OA\RequestBody(
     *      description="JSON for updating existed campaign. This endpoint is for request with one parameter (active, date_from or date_to). If you add more parameters, it will be processed only first of these.",
     *         @OA\JsonContent(
     *           type="object",
     *           @OA\Property(
     *              property="active", type="boolean"
     *           ),
     *          @OA\Property(
     *              property="date_from", type="date"
     *           ),
     *          @OA\Property(
     *              property="date_to", type="date"
     *          ),
     *          example={
     *              "active": true,"date_from":"2019-02-03", "date_fto":"2019-02-03"}
     *
     *       ),
     *
     * )
     * )
     */
    protected function smartCampaignUpdate(Request $request, $id)
    {
        $value = '';
        $valid = null;

        if ($request->has('active')) {
            $value = 'active';
            $valid = validator($request->only('active'), [
                'active' => 'required|boolean'
            ]);
        } else if ($request->has('date_from')) {
            $value = 'date_from';
            $valid = validator($request->only('date_from'), [
                'date_from' => 'required|string'
            ]);
        } else if ($request->has('date_to')) {
            $value = 'date_to';
            $valid = validator($request->only('date_to'), [
                'date_to' => 'required|string'
            ]);
        }

        if ($valid != null && $valid->fails()) {
            return response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($value == '') {
            return response()->json([
                'message' => 'Wrong request format. In smart settings you need to post active, date_from or date_to value.'
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            Campaign::find($id)->update([
                $value => $request[$value]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'message' => 'Wrong request format.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated campaign with id ' . $id . '!'
        ], Response::HTTP_CREATED);
    }


    //TODO: spravit taketo parametre pre vsetky ostatne endpointy, ale najprv je potrebne ziskat token

    /**
     * @OA\Get(
     *     path="/api/backoffice/campaigns/:id",
     *     tags={"CAMPAIGNS"},
     *     summary="Get campaign by id",
     *     description="Only for authenticated users.",
     *     operationId="getCampaign",
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Campaing id",
     *     required=true,
     *     schema = {
     *        "type": "string"
     *     }
     * ),
     *     @OA\Response(
     *         response=201,
     *         description="Success!")
     * )
     */
    protected function show($id)
    {
        try {
            $campaign = Campaign::find($id);
            if ($campaign == null) {
                return response()->json([
                    'message' => 'No results found.'
                ], Response::HTTP_NOT_FOUND);
            }
            $campaingWithTargeting = Campaign::with('targeting.urls')->find($id);
            return CampaignResourceDetail::make($campaingWithTargeting);
        } catch (\Exception $e) {
            return $e;
        }

    }

    /**
     * @OA\Get(
     *     path="/api/backoffice/campaigns/all",
     *     tags={"CAMPAIGNS"},
     *     summary="Get all campaigns",
     *     description="Only for authenticated users.",
     *     operationId="getAllCampaigns",
     *     @OA\Response(
     *         response=200,
     *         description="Success!")
     * )
     */
    protected function all()
    {
        if ($this->user->isBackOfficeUser()) {
            return CampaignResource::collection(Campaign::orderBy('active', 'desc')->orderBy('updated_at', 'desc')->get());
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/backoffice/campaigns/:id",
     *     tags={"CAMPAIGNS"},
     *     summary="Remove campaign by id - soft delete",
     *     description="Only for authenticated users.",
     *     operationId="removeCampaign",
     *     @OA\Response(
     *         response=201,
     *         description="Success!")
     * )
     * */
    public function delete($id)
    {
        if ($id == null) {
            $jsonError = response()->json([
                'error' => 'Campaign id is required'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        try {
            Campaign::find($id)->delete();
            return \response()->json([
                'message' => 'Successfully removed campaign.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function campaignClone($id)
    {

    }

    private function addTracking($campaignId, $userId, $data)
    {
        $campaignVersion = CampaignVersion::create([
            'campaign_id' => $campaignId,
            'user_id' => $userId,
            'campaign_data' => json_encode($data)
        ]);
        try {
            $campaignVersion->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully created version of campaign.'
        ], Response::HTTP_CREATED);
    }

    protected function campaignSettings($campaignId, $paymentSettings, $promoteSettings, $widgetSettings)
    {
        try {
            if (CampaignSettings::where('campaign_id', $campaignId)->first() == null) {
                // create
                $campaignSettings = CampaignSettings::create([
                    'campaign_id' => $campaignId,
                    'payment_settings' => json_encode($paymentSettings),
                    'promote_settings' => json_encode($promoteSettings),
                    'widget_settings' => json_encode($widgetSettings)
                ]);
                $campaignSettings->save();
            } else {
                // update
                CampaignSettings::where('campaign_id', $campaignId)->update([
                    'payment_settings' => json_encode($paymentSettings),
                    'promote_settings' => json_encode($promoteSettings),
                    'widget_settings' => json_encode($widgetSettings)
                ]);
            }
            return $this->storeImageToAllWidgets($widgetSettings, $campaignId);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function mapImageToCampaign($campaignId, $imageId)
    {
        if (CampaignImage::where('campaign_id', $campaignId)->first() != null) {
            return CampaignImage::where('campaign_id', $campaignId)->update([
                'image_id' => $imageId
            ]);
        }
        return CampaignImage::create([
            'campaign_id' => $campaignId,
            'image_id' => $imageId
        ])->save();

    }

    private function storeImageToAllWidgets($widgetSettings, $campaignId)
    {
        try {
            if ($widgetSettings['general']['background']['image']['url'] != null) {
                if (CampaignImage::where('campaign_id', $this->campaignId)->first() != null) {
                    // make update
                } else {
                    // make create
                    $campaignWidgets = Widget::all()->where('campaign_id', $campaignId);
                    foreach ($campaignWidgets as $w) {
                        if ($w->use_campaign_settings) {
                            foreach (DeviceType::all() as $device) {
                                CampaignImage::create([
                                    'campaign_id' => $campaignId,
                                    'widget_id' => $w->id,
                                    'image_id' => $widgetSettings['general']['background']['image']['id'],
                                    'device_type' => $device->id
                                ])->save();
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
        return \response()->json([
            'message' => 'Success!',
            'type' => 'campaign_settings'
        ], Response::HTTP_CREATED);

    }


    /**
     * @OA\Put(
     *     path="/api/backoffice/campaigns/:id/result",
     *     tags={"CAMPAIGNS"},
     *     summary="Update HTML result for every widget by campaign id.",
     *     description="Only for authenticated users.",
     *     operationId="updateCampaignResult",
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
     *            "widgets":{
     *                 "id": 1,
     *                 "desktop": "<div>example</div>",
     *                 "tablet": "<div>example</div>",
     *                 "mobile": "<div>example</div>"
     *             }
     *           }
     *
     *       ),
     *
     * )
     * )
     */
    protected function updateResult(Request $request, $id)
    {
        try {
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
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
        return \response()->json([
            'message' => 'Successfully updated campaign HTML results.'
        ], Response::HTTP_OK);

    }


    /**
     * @OA\Get(
     *     path="/api/backoffice/campaigns/:id/clone",
     *     tags={"CAMPAIGNS"},
     *     summary="Clone specific campaign.",
     *     description="Clone campaign and get result with all campaigns.",
     *     operationId="cloneCampaign",
     *     @OA\Response(
     *         response=200,
     *         description="Success!")
     * )
     */
    protected function cloneCampaign($id)
    {
        $campaignData = Campaign::find($id)->first();
        $campaignSettingsData = CampaignSettings::where('campaign_id', $id)->first();
        $widgetsData = Widget::all()->where('campaign_id', $id);

        try {
            // create new campaign from old data
            $newCampaign = Campaign::create([
                'name' => $campaignData['name'] . ' (Copy)',
                'description' => $campaignData['description'],
                'active' => false,
                'headline_text' => $campaignData['headline_text'],
                'date_from' => $campaignData['date_from'],
                'date_to' => $campaignData['date_to']
            ]);
            // create new campaign settings from old data
            CampaignSettings::create([
                'campaign_id' => $newCampaign->id,
                'promote_settings' => $campaignSettingsData['promote_settings'],
                'payment_settings' => $campaignSettingsData['payment_settings'],
                'widget_settings' => $campaignSettingsData['widget_settings']
            ]);

            // create widgets from old data
            foreach ($widgetsData as $widget) {
                $w = Widget::create([
                    'campaign_id' => $newCampaign->id,
                    'widget_type_id' => $widget['widget_type_id'],
                    'active' => false, // default disable widgets
                    'use_campaign_settings' => $widget['use_campaign_settings'],
                    'payment_type' => $widget['payment_type']
                ]);
                $widgetSettings = WidgetSettings::where('widget_id', $widget->id)->first();
                WidgetSettings::create([
                    'widget_id' => $w->id,
                    'desktop' => $widgetSettings['desktop'],
                    'tablet' => $widgetSettings['tablet'],
                    'mobile' => $widgetSettings['mobile']
                ]);

                // create campaign image records
                $campaignImages = CampaignImage::all()->where('widget_id', $widget->id);
                foreach ($campaignImages as $img) {
                    CampaignImage::create([
                        'campaign_id' => $newCampaign->id,
                        'widget_id' => $w->id,
                        'image_id' => $img['image_id'],
                        'device_type' => $img['device_type']
                    ]);
                }
            }
            $this->targetingService->cloneTargeting($campaignData, $newCampaign);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => 'There was an error during duplicating campaign with all widgets data. Please try again later.',
                'exception' => $e
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->all();
    }

}
