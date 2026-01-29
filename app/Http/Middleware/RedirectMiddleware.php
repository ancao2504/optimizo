<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Redirect;
use Illuminate\Support\Facades\Cache;

class RedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get current path with leading slash
        $path = '/' . $request->path();

        // Also check decoded path in case of URL encoding issues
        $decodedPath = '/' . urldecode($request->path());

        // Attempt to find a matching redirect
        // We can cache all redirects for performance if the table isn't too huge, 
        // or just query for the specific path. For now, let's query.
        // Caching is better for performance but requires cache clearing on update.
        // Let's stick to direct query for reliability first, or a short cache.

        $redirect = Redirect::where('status', true)
            ->where(function ($query) use ($path, $decodedPath) {
                $query->where('from_url', $path)
                    ->orWhere('from_url', $decodedPath);
            })
            ->first();

        if ($redirect) {
            $redirect->incrementHits();
            return redirect($redirect->to_url, (int) $redirect->type);
        }

        return $next($request);
    }
}
