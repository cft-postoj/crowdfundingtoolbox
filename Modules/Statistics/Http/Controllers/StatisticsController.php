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

    protected function getDonationsGroup(Request $request)
    {
        return \response()->json(
            array(
                'donations' => $this->statsDonationService->getDonationsGroup($request['from'], $request['to'], $request['interval'])
            ),
            Response::HTTP_OK
        );
    }

    protected function getDonorsGroup(Request $request)
    {
        return \response()->json(
            array(
                'donors' => $this->statsDonationService->getDonorsGroup($request['from'], $request['to'], $request['interval'])
            ),
            Response::HTTP_OK
        );
    }

    protected function getDonorsAndDonationTotal(Request $request)
    {
        return \response()->json(
            $this->statsDonationService->getDonorsAndDonationsTotalWithHistoric($request['from'], $request['to'])
            ,
            Response::HTTP_OK
        );
    }

}
