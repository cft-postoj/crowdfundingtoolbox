<?php


namespace Modules\UserManagement\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\TrackingService;

class TrackingController extends Controller
{

    private $trackingService;

    public function __construct()
    {
        $this->trackingService = new TrackingService();
    }

    protected function show(Request $request)
    {
        return $this->trackingService->show($request['tracking_visit_id'],$request['widget_id']);
    }

    protected function click(Request $request)
    {
        return $this->trackingService->click($request);
    }

    protected function insertValue(Request $request)
    {
        return $this->trackingService->insertValue($request);
    }

    protected function insertEmail(Request $request)
    {
        return $this->trackingService->insertEmail($request);
    }

    protected function initializeDonationInvalid(Request $request)
    {
        return $this->trackingService->initializeDonationInvalid($request);

    }
}