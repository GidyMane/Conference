<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in OR not an admin
        if (!Auth::check() || Auth::user()->role !== 'ADMIN') {
            // Redirect to admin login page
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
