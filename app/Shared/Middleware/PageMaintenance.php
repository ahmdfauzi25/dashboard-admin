<?php

namespace App\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PageMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        // Bypass untuk halaman utilitas agar admin tetap bisa mengatur
        if ($request->is('utils') || $request->is('utils/*') || $request->is('maintenance')) {
            return $next($request);
        }

        $routes = Cache::get('maintenance.routes', []);
        $message = Cache::get('maintenance.message', 'We are currently undergoing maintenance.');

        // Cek berdasarkan nama route terlebih dahulu
        $route = $request->route();
        $name = $route?->getName();
        if ($name && in_array($name, $routes, true)) {
            return response()->view('maintenance', [
                'message' => $message,
            ], 503);
        }

        // Fallback: cek path URI
        $uri = trim($request->path(), '/');
        $uriMatches = Cache::get('maintenance.uris', []);
        foreach ($uriMatches as $pattern) {
            if ($pattern !== '' && $request->is($pattern)) {
                return response()->view('maintenance', [
                    'message' => $message,
                ], 503);
            }
        }

        return $next($request);
    }
}


