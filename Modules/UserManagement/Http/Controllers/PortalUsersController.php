<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\User;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\UserService;

class PortalUsersController extends Controller
{
    private $userService;
    private $portalUserService;

    public function __construct(PortalUserService $portalUserService, UserService $userService)
    {
        $this->userService = $userService;
        $this->portalUserService = $portalUserService;
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
}
