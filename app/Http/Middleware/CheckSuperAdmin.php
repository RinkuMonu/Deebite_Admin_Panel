<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
  
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->role === 'superadmin'){
            return $next($request);
        }
        return response()->json([
            'message' => 'Access Denied! Only SuperAdmin can access this panel.'
        ], 403);
    }
}
