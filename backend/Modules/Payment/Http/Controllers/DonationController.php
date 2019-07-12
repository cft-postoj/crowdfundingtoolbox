<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Services\DonationService;

class DonationController extends Controller
{

    private $donationService;

    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    protected function initialize(Request $request)
    {
        //pripojit sa na service a zavolat endpoint
        return $this->donationService->initialize($request);
    }

    protected function getAllDonations(Request $request)
    {

        return $this->donationService->getDonationInTimeInterval($request['from'], $request['to'], $request['interval']);
    }

    protected function getDetail($id)
    {
        return $this->donationService->getDetail($id);
    }

    protected function updateAssignemnt(Request $requestt, $id)
    {
        return $this->donationService->updateAssignment($requestt, $id);
    }

    protected function cancelAssignment($id)
    {
        return $this->donationService->cancelAssignment($id);
    }

}
