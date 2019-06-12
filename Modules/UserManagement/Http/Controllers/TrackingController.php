<?php


namespace Modules\UserManagement\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\Services\TrackingService;

class TrackingController extends Controller
{

    private $trackingService;

    public function __construct()
    {
        $this->trackingService = new TrackingService();
    }

    protected function click(Request $request)
    {
        return $this->trackingService->click($request);
    }

}