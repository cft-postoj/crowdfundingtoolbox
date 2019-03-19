<?php

namespace App\Http\Controllers\BackOfficeAPI;

use App\BackOfficeAPI\CrowdfundingSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CrowdfundingSettingsController extends Controller
{
    private $apiRequest;

    /**
     * @OA\Put(
     *     path="/api/backoffice/crowdfunding-settings",
     *     tags={"GENERAL SETTINGS"},
     *     summary="Crowdfunding Settings",
     *     description="Only for authenticated users.",
     *     operationId="crowdFundingSettings",
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
     *              property="type", type="string"
     *           ),
     *          @OA\Property(
     *              property="settings", type="json"
     *          ),
     *          example={
     *              "type": "general",
     *              "settings": {"color": {"primary": "#000000", "secondary": "#ff0000"}}
     *          }
     *
     *       )
     * )
     * )
     */
    protected function index(Request $request)
    {
        if ($request['type'] != null) {
            $this->apiRequest = $request;
            return $this->updateSettings();
        }
        return \response()->json([
            'error' => 'Parameter type is missing in request.'
        ], Response::HTTP_BAD_REQUEST);
    }

    private function updateSettings()
    {
        try {
            CrowdfundingSettings::where('type', $this->apiRequest['type'])->update([
                'settings'  => json_encode($this->apiRequest['settings'])
            ]);

        } catch (\Exception $e) {
            return \response()->json([
                'error' =>  $e
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated crowdfunding settings!'
        ], Response::HTTP_CREATED);
    }
}
