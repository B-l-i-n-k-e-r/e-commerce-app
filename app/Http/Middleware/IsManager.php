<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND has the manager flag
        if (auth()->check() && auth()->user()->is_manager) {
            return $next($request);
        }

        // Redirect with a flash message if unauthorized
        return redirect('/')->with('error', 'You do not have manager access.');
    }
}