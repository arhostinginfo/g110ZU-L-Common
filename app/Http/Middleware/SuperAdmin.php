<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!($request->session()->has('super_user_id'))) {
            return redirect()->route('adminlogin');
        }

        $response = $next($request);

        // Prevent authenticated pages from being stored in browser/proxy cache
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, private');
        $response->headers->set('Pragma', 'no-cache');

        return $response;
    }
}
