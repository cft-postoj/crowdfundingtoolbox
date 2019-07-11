<?php

namespace Modules\Statistics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Statistics\Services\StatsDonationService;
use Modules\Statistics\Services\StatsDonorService;

class StatisticsController extends Controller
{

    private $statsDonationService;
    private $statsDonorService;

    public function __construct(StatsDonationService $statsDonationService, StatsDonorService $statsDonorService)
    {
        $this->statsDonationService = $statsDonationService;
        $this->statsDonorService = $statsDonorService;
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

    protected function donorsAll(Request $request)
    {
        return \response()->json(
            $this->statsDonorService->getDonors($request['from'], $request['to'], $request['monthly'],
                $request['dataType'], $request['limit']),
            Response::HTTP_OK
        );
    }

    protected function getDonationsAll(Request $request)
    {
        return \response()->json(
            $this->statsDonationService->getDonations($request['from'], $request['to'], $request['monthly']),
            Response::HTTP_OK
        );
    }

    protected function getDonorsTotal(Request $request)
    {
        return \response()->json(
            $this->statsDonorService->getDonorsTotal($request['from'], $request['to']),
            Response::HTTP_OK
        );
    }


}
