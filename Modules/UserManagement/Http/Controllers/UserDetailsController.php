<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\UserDetailService;

class UserDetailsController extends Controller
{
    private $userDetailService;

    public function __construct(UserDetailService $userDetailService)
    {
        $this->userDetailService = $userDetailService;
    }

    protected function get()
    {
        return $this->userDetailService->getDetailsByToken();
    }
}
