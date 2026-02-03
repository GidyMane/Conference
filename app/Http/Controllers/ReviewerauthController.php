<?php

namespace App\Http\Controllers;

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

        // Reviewer-only login
        $credentials['role'] = 'REVIEWER';
        $credentials['is_active'] = true;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // 🔐 FORCE password change on first login
            if (Auth::user()->password_setup_token !== null) {
                return redirect()
                    ->route('reviewer.password.change')
                    ->with('warning', 'You must change your password before continuing.');
            }

            return redirect()->intended(route('reviewer.dashboard'))
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Invalid reviewer credentials.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('reviewer.login')
            ->with('success', 'Logged out successfully.');
    }

    public function showChangePasswordForm()
    {
        return view('reviewer.auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
            'password_setup_token' => null,
            'password_setup_expires_at' => null,
        ]);

        return redirect()->route('reviewer.dashboard')
            ->with('success', 'Password updated successfully.');
    }
}
