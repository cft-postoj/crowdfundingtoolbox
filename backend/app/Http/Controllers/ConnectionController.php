<?php

namespace App\Http\Controllers;

use App\Http\Services\ConnectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConnectionController extends Controller
{
    private $connectionService;

    public function __construct(ConnectionService $connectionService)
    {
        $this->connectionService = $connectionService;
    }

    protected function getPortalUrl()
    {
        return response()->json($this->connectionService->getPortalUrl(), Response::HTTP_OK);
    }

    protected function getBackendUrl()
    {
        return response()->json($this->connectionService->getBackendUrl(), Response::HTTP_OK);
    }

    protected function updatePortalUrl(Request $request)
    {
        $this->connectionService->setPortalUrl($request);
        return response()->json([
            'message' => 'Successfully updated portal URL.'
        ], Response::HTTP_CREATED);
    }
}
