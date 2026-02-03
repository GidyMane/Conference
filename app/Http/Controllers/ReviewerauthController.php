<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReviewerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.reviewerlogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // DUMMY AUTHENTICATION - Replace with real authentication
        // This allows login with demo credentials without database
        if ($credentials['email'] === 'reviewer@kalro.org' && $credentials['password'] === 'reviewer123') {
            // Create a dummy session
            session([
                'reviewer_logged_in' => true,
                'reviewer_user' => [
                    'id' => 1,
                    'name' => 'Dr. John Kamau',
                    'email' => 'reviewer@kalro.org',
                    'sub_theme_id' => 1,
                    'sub_theme_name' => 'Climate-Smart Agriculture',
                    'organization' => 'University of Nairobi',
                    'password_changed' => true
                ]
            ]);
            
            return redirect()->intended(route('reviewer.dashboard'))
                ->with('success', 'Welcome back, Dr. Kamau!');
        }

        // For real authentication with database, use this:
        /*
        if (Auth::guard('reviewer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('reviewer.dashboard'));
        }
        */

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // For dummy authentication
        session()->forget(['reviewer_logged_in', 'reviewer_user']);
        
        // For real authentication
        // Auth::guard('reviewer')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('reviewer.login')
            ->with('success', 'You have been logged out successfully.');
    }
}