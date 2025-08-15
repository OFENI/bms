<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // User is admin, allow request to continue
            return $next($request);
        }

        // User is NOT admin, redirect to homepage with error message
        return redirect('/')->with('error', 'Access denied. Admins only.');
    }
}
