<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access admin panel.');
        }

        // Check if user has permission to access admin panel
        if (!auth()->user()->hasPermission('access_admin_panel')) {
            abort(403, 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
