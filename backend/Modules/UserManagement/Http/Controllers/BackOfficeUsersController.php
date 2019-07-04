<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\BackOfficeUserService;

class BackOfficeUsersController extends Controller
{
    private $backofficeUserService;

    public function __construct(BackOfficeUserService $backOfficeUserService)
    {
        $this->backofficeUserService = $backOfficeUserService;
    }

    protected function get()
    {
        return $this->backofficeUserService->get();
    }

    protected function update(Request $request)
    {
        return $this->backofficeUserService->update($request);
    }

    protected function create(Request $request)
    {
        return $this->backofficeUserService->create($request);
    }

    protected function checkGeneratedToken(Request $request)
    {
        return $this->backofficeUserService->checkGeneratedResetToken($request, $request->route()->getPrefix());
    }
}
