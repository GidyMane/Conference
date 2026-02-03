<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // DUMMY AUTHENTICATION - Replace with real authentication
        // This allows login with demo credentials without database
        if ($credentials['email'] === 'admin@kalro.org' && $credentials['password'] === 'password123') {
            // Create a dummy session
            session([
                'admin_logged_in' => true,
                'admin_user' => [
                    'id' => 1,
                    'name' => 'Admin User',
                    'email' => 'admin@kalro.org',
                    'role' => 'administrator'
                ]
            ]);
            
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, Admin!');
        }

        // For real authentication with database, use this:
        /*
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }
        */

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // For dummy authentication
        session()->forget(['admin_logged_in', 'admin_user']);
        
        // For real authentication
        // Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}