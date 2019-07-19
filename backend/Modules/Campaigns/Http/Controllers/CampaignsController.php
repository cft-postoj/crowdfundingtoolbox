<?php

namespace Modules\Campaigns\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use JWTAuth;
use Modules\Campaigns\Providers\CampaignPromoteService;
use Modules\Campaigns\Services\CampaignService;
use Modules\Campaigns\Services\WidgetService;
use Modules\Campaigns\Transformers\CampaignResource;
use Modules\Campaigns\Transformers\CampaignResourceDetail;
use Modules\Campaigns\Transformers\WidgetResource;
use Modules\Targeting\Providers\TargetingService;
use Modules\UserManagement\Http\Controllers\UserServiceController;

class CampaignsController extends Controller
{
    private $widgetsController;
    private $widgetService;
    private $targetingService;
    private $userService;
    private $promoteService;
    private $campaignService;

    public function __construct()
    {
        $this->userService = new UserServiceController();
        $this->widgetsController = new WidgetsController();
        $this->widgetService = new WidgetService();
        $this->targetingService = new TargetingService();
        $this->promoteService = new CampaignPromoteService();
        $this->campaignService = new CampaignService();
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
     *          )
     */
    protected function create(Request $request)
    {
        $valid = validator($request->only('active', 'name', 'promote_settings'), [
            'active' => 'required|boolean',
            'name' => 'required|string',
            'promote_settings' => 'required|array',
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }

        $campaign = $this->campaignService->create($request);

        return response()->json([
            'message' => 'Successfully created campaign!',
            'campaign' => $campaign,
            //TODO: odstranit widgets a pouzivat len tie z kampane
            'widgets' => WidgetResource::collection($this->widgetService->getWidgetsByCampaginReduced($campaign))
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
     *          )
     */
    protected function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'active', 'promote_settings'), [
            'name' => 'required|string',
            'active' => 'required|boolean',
            'promote_settings' => 'required|array'
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
        if ($campaign = $this->campaignService->get($id) == null) {
            $jsonError = response()->json([
                'error' => 'Wrong campaign ID.'
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }


        $campaign = $this->campaignService->update($request);

        return response()->json([
            'message' => 'Successfully updated campaign with id ' . $id . '!',
            'campaign' => $campaign,
            'widgets' => WidgetResource::collection($this->widgetService->getWidgetsByCampaginReduced($campaign))
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
        } else if ($request->has('start_date_value') && $request->has('end_date_value')) {
            $value = 'dates_value';
            $valid = validator($request->only('start_date_value', 'end_date_value'), [
                'start_date_value' => 'required|string',
                'end_date_value' => 'required|string'
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
            $campaign = $this->campaignService->smartUpdate($request, $id, $value);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'message' => 'Wrong request format.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated campaign with id ' . $id . '!',
            'campaign' => $campaign
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
            $campaign = $this->campaignService->get($id);
            if ($campaign == null) {
                return response()->json([
                    'message' => 'No results found.'
                ], Response::HTTP_NOT_FOUND);
            }
            return CampaignResourceDetail::make($campaign);
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
        return CampaignResource::collection($this->campaignService->getAll());
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
            $this->campaignService->delete($id);
            return \response()->json([
                'message' => 'Successfully removed campaign.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
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
            $this->widgetService->updateResults($request);
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
        try {
            $this->campaignService->clone($id);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => 'There was an error during duplicating campaign with all widgets data. Please try again later.',
                'exception' => $e,
                'trace' => $e->getTrace()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->all();
    }


    /*
     * Portal access - get filtered campaign widgets
     * 1) by logged in user (donating, etc.)
     * 2) by unregistered user
     */
    protected function getCampaignWidgets()
    {
        $user = (JWTAuth::getToken())
            ? ((JWTAuth::check()) ? JWTAuth::parseToken()->authenticate() : null)
            : null;
        try {
            $result = $this->widgetService->getCampaignWidgets($user);
            return \response()->json(
                array(
                    'widgets' => $result
                ),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function getCampaignByWidgetId($id)
    {
        return $this->campaignService->getByWidgetId($id);
    }
}
