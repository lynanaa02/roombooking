<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya untuk halaman dashboard admin
        if ($request->route() && $request->route()->getName() === 'admin.dashboard') {
            if (!Session::has('visit_count')) {
                Session::put('visit_count', 1);
                Session::put('first_visit', now());
                Session::put('last_visit', now());
            } else {
                Session::increment('visit_count');
                Session::put('last_visit', now());
            }

            // Debug log
            Log::info('Visit count: ' . Session::get('visit_count'));
        }

        return $next($request);
    }
}
