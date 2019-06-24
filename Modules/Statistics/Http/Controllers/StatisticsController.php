<?php

namespace Modules\Statistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Statistics\Services\StatsDonationService;

class StatisticsController extends Controller
{

    private $statsDonationService;

    public function __construct(StatsDonationService $statsDonationService)
    {
        $this->statsDonationService = $statsDonationService;
    }

    protected function getAllDonations(Request $request)
    {
        return \response()->json(
            array(
                'donations' => $this->statsDonationService->getDonationsBetweenOverall($request['from'], $request['to'], $request['interval'])
            ),
            Response::HTTP_OK
        );
    }

}
