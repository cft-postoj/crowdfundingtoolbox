<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Emails\AutoRegistrationEmail;
use Modules\UserManagement\Services\BackOfficeUserService;
use Illuminate\Support\Facades\Mail;

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

    protected function all()
    {
        return $this->backofficeUserService->all();
    }

    protected function delete($id)
    {
        return $this->backofficeUserService->delete($id);
    }
}
