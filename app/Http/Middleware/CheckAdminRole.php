<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json([
                'status' => false,
                'message' => 'Access denied. Admins only.',
            ], 403);
        }

        return $next($request);
    }
}