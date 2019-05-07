<?php

namespace App\Http\Controllers\BackOfficeAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function isAuthorized()
    {
        return response()->json([
            'message' => 'token is valid',
            'expires_at' => Auth::user()->token()->expires_at,
            'token_id' => Auth::user()->token()->id
        ], Response::HTTP_OK);
    }
}
