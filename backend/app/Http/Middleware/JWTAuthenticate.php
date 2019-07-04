<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;
use Tymon\JWTAuth\Token;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class JWTAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string|null @guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            if(!$request->headers->has('csrf-token')) throw new TokenMismatchException();
            $rawToken = $request->cookie('token');
            $token = new Token($rawToken);
            $payload = JWTAuth::decode($token);
            if($payload['csrf-token'] != $request->headers->get('csrf-token')) throw new TokenMismatchException();
            Auth::loginUsingId($payload['sub']);
        } catch(\Exception $e) {
            if( $e instanceof TokenExpiredException) {
                // TODO token refresh here
            }
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
