<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\ExcludeFromTargetingService;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\UserService;

class PortalUsersController extends Controller
{
    private $userService;
    private $portalUserService;
    private $excludeFromTargetingService;

    public function __construct(PortalUserService $portalUserService, UserService $userService, ExcludeFromTargetingService $excludeFromTargetingService)
    {
        $this->userService = $userService;
        $this->portalUserService = $portalUserService;
        $this->excludeFromTargetingService = $excludeFromTargetingService;
    }

    public function all()
    {
        return \response()->json(
            $this->portalUserService->getAll(),
            Response::HTTP_OK
        );
    }

    public function getById($id)
    {
        return \response()->json(
            $this->portalUserService->getById($id),
            Response::HTTP_OK
        );
    }

    public function create(Request $request)
    {
        return $this->portalUserService->create($request);
    }

    public function isUserLoggedIn()
    {
        return $this->portalUserService->checkToken();
    }

    public function logout()
    {
        return $this->portalUserService->logout();
    }

    protected function authenticate(Request $request)
    {
        return $this->portalUserService->authenticate($request);
    }

    protected function resetPassword(Request $request)
    {
        return $this->portalUserService->resetPassword($request);
    }

    protected function hasUserGeneratedToken(Request $request)
    {
        /* TODO - add method */
        return $this->portalUserService->hasUserGeneratedToken($request);
    }

    protected function excludeFromCampaignsTargeting(Request $request, $portalUserId)
    {
        return $this->excludeFromTargetingService->exclude($request, $portalUserId);
    }

    protected function getDonationsDetailInfo($id)
    {
        return $this->portalUserService->getDonationsDetailInfo($id);
    }

    protected function getDonationsByUserPortalAndDate(Request $request, $id)
    {
        return $this->portalUserService->getDonationsByUserPortalAndDate($id, $request['from'], $request['to']);
    }


}
