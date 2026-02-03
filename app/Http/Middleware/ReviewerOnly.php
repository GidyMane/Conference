<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and role is REVIEWER
        if (!Auth::check() || Auth::user()->role !== 'REVIEWER') {
            return redirect()->route('reviewer.login')
                ->with('error', 'You must be logged in as a reviewer to access this page.');
        }

        return $next($request);
    }
}
