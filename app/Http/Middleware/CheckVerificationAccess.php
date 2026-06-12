<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckVerificationAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->can('verify suppliers')) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
        return $next($request);
    }
}