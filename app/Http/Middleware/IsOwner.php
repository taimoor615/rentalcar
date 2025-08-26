<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOwner
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isOwner()) {
            abort(403, 'Access denied. Owber role required.');
        }

        return $next($request);
    }
}
