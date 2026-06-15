<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyStaticToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('api_settings.enabled')) {
            $token = $request->bearerToken() ?: $request->header('X-API-Key');
            $expectedToken = config('api_settings.static_token');

            if (!$token) {
                return response()->json([
                    "status" => false,
                    'message' => 'Unauthorized. API token is missing.',
                    // 'message' => 'Unauthorized. API token is missing. Please provide Bearer token or X-API-Key header.',
                    // 'hint' => 'Example: Authorization: Bearer YOUR_TOKEN or X-API-Key: YOUR_TOKEN'
                ], 401);
            }

            if (!$token || $token !== $expectedToken) {
                return response()->json([
                    "status" => false,
                    'message' => 'Unauthorized. Invalid or missing API token provided.',
                    // 'hint' => 'Please check your API token and try again.'
                ], 401);
            }
        }

        return $next($request);
    }
}
