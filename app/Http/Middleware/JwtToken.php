<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Try JWT Authentication First
        try {
            if (\Illuminate\Support\Facades\Auth::guard('api')->check()) {
                return $next($request);
            }
        } catch (\Exception $e) {
            // Ignore exception here so we can fallback to static token
        }

        // 2. Fallback to Static Token
        if (config('api_settings.enabled')) {
            $token = $request->bearerToken() ?: $request->header('X-API-Key');
            $expectedToken = config('api_settings.static_token');

            if ($token && $token === $expectedToken) {
                return $next($request);
            }
        }

        // If both failed, return unauthorized
        return response()->json([
            "status" => false,
            'message' => 'Unauthorized. Please provide a valid JWT or Static Token.',
        ], 401);
    }
}
