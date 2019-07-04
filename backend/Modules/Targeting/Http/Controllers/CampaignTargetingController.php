<?php

namespace Modules\Targeting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Targeting\Services\CampaignTargetingService;

class CampaignTargetingController extends Controller
{
    private $campaignTargetingService;

    public function __construct(CampaignTargetingService $campaignTargetingService)
    {
        $this->campaignTargetingService = $campaignTargetingService;
    }

    protected function getUsersCount(Request $request)
    {
        return $this->campaignTargetingService->getUsersCount($request);
    }
}
