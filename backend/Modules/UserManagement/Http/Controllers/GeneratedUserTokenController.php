<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\UserManagement\Services\GeneratedUserTokenService;

class GeneratedUserTokenController extends Controller
{
    private $generatedUserTokenService;

    public function __construct(GeneratedUserTokenService $generatedUserTokenService)
    {
        $this->generatedUserTokenService = $generatedUserTokenService;
    }

    protected function hasUserGeneratedToken(Request $request)
    {
        return $this->generatedUserTokenService->isValid($request);
    }
}
