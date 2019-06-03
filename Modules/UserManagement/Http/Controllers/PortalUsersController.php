<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Services\PortalUserService;

class PortalUsersController extends Controller
{
    private $portalUserService;

    public function __construct(PortalUserService $portalUserService)
    {
        $this->portalUserService = $portalUserService;
    }

    public function getAllPortalUsers()
    {
        return \response()->json(
            $this->portalUserService->getPortalUsers(),
            Response::HTTP_OK
        );
    }
}
