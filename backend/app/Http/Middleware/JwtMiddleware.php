<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Modules\UserManagement\Entities\BackOfficeUser;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
            $requestUri = $request->server()['REQUEST_URI'];
            $payload = JWTAuth::parseToken()->getPayload();
            // validate if backoffice user access to backoffice content (information about role is in JWT token, portal user has no role)
            if (strpos($requestUri, '/api/backoffice') !== false && JWTAuth::parseToken()->getPayload()->get('role') === null) {
                return response('Unauthorized.', 401);
            }
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid']);
            } else if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token is Expired']);
            } else {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
