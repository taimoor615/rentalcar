<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsRenter
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isRenter()) {
            abort(403, 'Access denied. Renter role required.');
        }

        return $next($request);
    }
}
