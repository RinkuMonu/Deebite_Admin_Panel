<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MultiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles  Allowed roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $roles = ['user', 'vendor', 'delivery'];

        if (!$user || !in_array($user->role, $roles)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Optional: pass the role to the request
        $request->merge(['current_role' => $user->role]);

        return $next($request);
    }
}