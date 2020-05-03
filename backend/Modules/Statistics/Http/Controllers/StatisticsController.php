<?php

namespace Modules\Statistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Statistics\Services\GeneralStatsService;
use Modules\Statistics\Services\StatsDonationService;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Entities\PortalUser;

class StatisticsController extends Controller
{

    private $statsDonationService;
    private $portalUserService;
    private $generalStatsService;
    protected $client;

    public function __construct(StatsDonationService $statsDonationService, PortalUserService $portalUserService, GeneralStatsService $generalStatsService)
    {
        $this->statsDonationService = $statsDonationService;
        $this->portalUserService = $portalUserService;
        $this->generalStatsService = $generalStatsService;
    }

    protected function getDonationsGroup(Request $request)
    {
        return \response()->json(
            array(
                'donations' => $this->statsDonationService->getDonationsGroup($request['from'], $request['to'], $request['interval'])),
            Response::HTTP_OK
        );
    }

    protected function getDonorsGroup(Request $request)
    {
        return \response()->json(
            array(
                'donors' => $this->statsDonationService->getDonorsGroup($request['from'], $request['to'], $request['interval'])),
            Response::HTTP_OK
        );
    }

    protected function getDonorsAndDonationTotal(Request $request)
    {
        return \response()->json(
            $this->statsDonationService->getDonorsAndDonationsTotalWithHistoric($request['from'], $request['to']),
            Response::HTTP_OK
        );
    }

    protected function getDonorsTotal(Request $request)
    {
        return \response()->json(
            $this->portalUserService->getDonorsTotal($request['from'], $request['to']),
            Response::HTTP_OK
        );
    }

    protected function articles(Request $request)
    {
        return \response()->json(
            $this->generalStatsService->articlesStatistics($request),
            Response::HTTP_OK
        );
    }

    protected function campaigns(Request $request)
    {
        return \response()->json(
            $this->generalStatsService->campaignsStatistics($request),
            Response::HTTP_OK
        );
    }

    protected function campaign($id, $period)
    {
        return \response()->json(
            $this->generalStatsService->getCampaignStatsById($period, $id),
            Response::HTTP_OK
        );
    }


}
