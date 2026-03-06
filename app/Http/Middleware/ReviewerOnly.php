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
        $user = Auth::user();

        // Not logged in or not a reviewer type
        if (!$user || !in_array($user->role, ['REVIEWER', 'TEMP_REVIEWER'])) {
            return redirect()->route('reviewer.login')
                ->with('error', 'You must be logged in as a reviewer to access this page.');
        }

        // If TEMP_REVIEWER, check expiry
        if ($user->role === 'TEMP_REVIEWER') {
            if (!$user->tempReviewer || $user->tempReviewer->expires_at < now()) {
                Auth::logout();
                return redirect()->route('reviewer.login')
                    ->with('error', 'Your temporary access has expired.');
            }
        }

        return $next($request);
    }
}