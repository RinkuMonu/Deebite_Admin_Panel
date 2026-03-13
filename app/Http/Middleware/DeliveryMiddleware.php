<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user() || auth()->user()->role != 'delivery_partner') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
