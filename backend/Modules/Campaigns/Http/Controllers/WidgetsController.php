<?php

namespace Modules\Campaigns\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Campaigns\Services\WidgetResultService;
use Modules\Campaigns\Services\WidgetService;
use Modules\Campaigns\Services\WidgetSettingsService;
use Modules\Campaigns\Transformers\WidgetResource;
use Modules\UserManagement\Services\TrackingService;

class WidgetsController extends Controller
{

    private $widgetSettings;
    private $widgetSettingsService;
    private $widgetService;
    private $widgetResultService;
    private $trackingService;

    public function __construct(
        WidgetService $widgetService,
        WidgetSettingsService $widgetSettingsService,
        WidgetResultService $widgetResultService,
        TrackingService $trackingService)
    {
        $this->widgetSettings = array();
        $this->widgetService = $widgetService;
        $this->widgetSettingsService = $widgetSettingsService;
        $this->widgetResultService = $widgetResultService;
        $this->trackingService = $trackingService;
    }


    //TODO: create routing and fill data from request to widget
//    private function create()
//    {
//        $this->widgetService->create();
//        return response()->json([
//            'message' => 'Successfully created widgets!'
//        ], Response::HTTP_CREATED);
//    }


    protected function delete(Request $request)
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
            $widget = $this->widgetService->get($id);
            if ($widget == null) {
                return \response()->json([
                    'error' => 'Widget is not exist.'
                ], Response::HTTP_BAD_REQUEST);
            }
            return WidgetResource::make($widget);
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
    protected function getWidgetsByCampaignId($campaignId) // At the moment, only for these types of widgets: Sidebar, Fixed and Leaderboard
    {
        try {
            $widgets = $this->widgetService->getWidgetsByCampaignId($campaignId);
            return WidgetResource::collection($widgets);
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
    protected function update(Request $request, $id)
    {
        $valid = $this->validateRequest($request);
        if ($valid['status'] != 'ok') {
            return \response()->json([
                $valid
            ], Response::HTTP_BAD_REQUEST);
        }
        try {
            $widget = $this->widgetService->update($request);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => 'There was a problem with widget updating.',
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'message' => 'Widget was successfully updated.',
            'widget' => $widget
        ], Response::HTTP_CREATED);
    }

    private function validateRequest($request)
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
    protected function getWidgets(Request $request)
    {
        try {
            $onlyThreeWidgets = $this->widgetService->getWidgets(
                $request['url'], $request['article'],
                $request['user_cookie'], $request['user_id'], $_SERVER['REMOTE_ADDR']);
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e->getMessage()
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
            $this->widgetResultService->update($request, $id);
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
            $this->widgetService->smartUpdate($id, $request['active']);
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
