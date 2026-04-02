<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $corsConfig = config('cors');
        $origin = $request->header('Origin');

        // Check if origin is allowed
        if ($this->isOriginAllowed($origin, $corsConfig)) {
            $headers = [
                'Access-Control-Allow-Origin' => $origin,
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Allow-Credentials' => 'true',
            ];

            // Handle preflight requests
            if ($request->getMethod() === 'OPTIONS') {
                return response('OK', 200, $headers);
            }

            return $next($request)->withHeaders($headers);
        }

        return $next($request);
    }

    /**
     * Check if the origin is allowed
     */
    private function isOriginAllowed($origin, $corsConfig)
    {
        if (in_array('*', $corsConfig['allowed_origins'])) {
            return true;
        }

        if (in_array($origin, $corsConfig['allowed_origins'])) {
            return true;
        }

        foreach ($corsConfig['allowed_origins_patterns'] as $pattern) {
            if (preg_match($pattern, $origin)) {
                return true;
            }
        }

        return false;
    }
}
