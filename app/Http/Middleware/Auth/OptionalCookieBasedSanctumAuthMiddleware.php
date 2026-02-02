<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class OptionalCookieBasedSanctumAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('auth-token');
        if (!$token) {
            return $next($request);
        }
        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken || !$accessToken->tokenable) {
            return $next($request);
        }
        if ($accessToken->expires_at || $accessToken->expires_at->isPast()) {
            $accessToken->delete();
            return $next($request);
        }
        Auth::setUser($accessToken->tokenable);
        $request->setUserResolver(fn() => $accessToken->tokenable);
        return $next($request);
    }
}
