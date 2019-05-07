<?php

namespace App\Http\Controllers\BackOfficeAPI;

use App\BackOfficeAPI\CrowdfundingSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CrowdfundingSettingsController extends Controller
{
    private $apiRequest;


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
