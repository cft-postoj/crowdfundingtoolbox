<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\UserDetailService;
use Modules\UserManagement\Services\UserPaymentOptionService;

class UserDetailsController extends Controller
{
    private $userDetailService;
    private $userPaymentOptionService;

    public function __construct(UserDetailService $userDetailService, UserPaymentOptionService $userPaymentOptionService)
    {
        $this->userDetailService = $userDetailService;
        $this->userPaymentOptionService = $userPaymentOptionService;
    }

    protected function get()
    {
        return $this->userDetailService->getDetailsByToken();
    }

    protected function update(Request $request)
    {
        return $this->userDetailService->update($request, null);
    }

    protected function updatePortalUserFromBackoffice(Request $request, $id)
    {
        return $this->userDetailService->update($request, $id);
    }

    protected function getBase()
    {
        return $this->userDetailService->getBase();
    }

    protected function updatePreferredPaymentsPairing(Request $request, $id)
    {
        return $this->userPaymentOptionService->update(array('pairing_type' => $request['pairing_type']), $id);
    }

    protected function getLastUpdated($portalUserId)
    {
        return $this->userDetailService->getLastUpdated($portalUserId);
    }
}
