<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TempReviewer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TempReviewerWelcomeMail;
use App\Mail\FinanceWelcomeMail;

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

if (Auth::attempt($credentials, $request->boolean('remember'))) {
    $request->session()->regenerate();

    $user = Auth::user();

    // Check active
    if (!$user->is_active) {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Your account is inactive.'
        ]);
    }

    // Ensure only reviewers can login here
    if (!in_array($user->role, ['REVIEWER','TEMP_REVIEWER','FINANCE'])) {
        Auth::logout();
        return back()->withErrors([
            'email' => 'Unauthorized access.'
        ]);
    }

    // TEMP REVIEWER EXPIRY CHECK
    if ($user->role === 'TEMP_REVIEWER') {
        if (!$user->tempReviewer || $user->tempReviewer->expires_at < now()) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your temporary access has expired.'
            ]);
        }
    }

    // Force password change if needed
    if ($user->password_setup_token !== null) {
        return redirect()
            ->route('reviewer.password.change')
            ->with('warning', 'You must change your password before continuing.');
    }

    return redirect()->route('reviewer.dashboard')
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
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // lowercase
                'regex:/[A-Z]/',      // uppercase
                'regex:/[0-9]/',      // number
                'regex:/[@$!%*#?&]/', // special character
            ],
        ], [
            'password.min'   => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include uppercase, lowercase, number, and special character.',
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

public function storeTempReviewer(Request $request)
{
    // Validate
    $validated = $request->validate([
        'full_name'    => 'required|string|max:255',
        'email'        => 'required|email|unique:users,email',
        'sub_theme_id' => 'required|exists:sub_themes,id',
        'expires_days' => 'required|integer|min:1|max:365', // This validates it's an integer
    ]);

    // Generate password
    $plainPassword = Str::random(10);
    
    // Create user
    $user = new User();
    $user->full_name = $validated['full_name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($plainPassword);
    $user->role = 'TEMP_REVIEWER';
    $user->is_active = true;
    $user->password_setup_token = Str::uuid();
    $user->password_setup_expires_at = now()->addHours(24);
    $user->save();
    
    // Create temp reviewer record - CAST TO INT HERE
    $tempReviewer = new TempReviewer();
    $tempReviewer->user_id = $user->id;
    $tempReviewer->sub_theme_id = $validated['sub_theme_id'];
    $tempReviewer->expires_at = now()->addDays((int)$validated['expires_days']); // ← CAST TO INT
    $tempReviewer->save();
    
    // Now send email
    try {
        Mail::to($user->email)->send(new TempReviewerWelcomeMail($user, $plainPassword));
        
        return back()->with('success', 'Temporary reviewer created successfully. Email has been sent.');
    } catch (\Exception $e) {
        \Log::error('Email failed but user created: ' . $e->getMessage());
        
        return back()->with('warning', 'Temporary reviewer created but email failed. Please check logs.');
    }
}

public function extendTempReviewer(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'expires_days' => 'required|integer|min:1|max:365',
    ]);

    // Get user
    $user = User::findOrFail($validated['user_id']);

    if ($user->role !== 'TEMP_REVIEWER') {
        return back()->with('error', 'Selected user is not a temporary reviewer.');
    }

    $tempReviewer = $user->tempReviewer;

    if (!$tempReviewer) {
        return back()->with('error', 'Temporary reviewer record not found.');
    }

    // Extend expiry properly
    $baseDate = $tempReviewer->expires_at > now()
        ? $tempReviewer->expires_at
        : now();

    $tempReviewer->expires_at = $baseDate->addDays((int)$validated['expires_days']);
    $tempReviewer->save();

    return back()->with('success', 'Temporary reviewer extended successfully.');
}

public function storeFinanceUser(Request $request)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email',
    ]);

    $plainPassword = Str::random(10);

    $user = new User();
    $user->full_name = $validated['full_name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($plainPassword);
    $user->role = 'FINANCE';
    $user->is_active = true;
    $user->password_setup_token = Str::uuid();
    $user->password_setup_expires_at = now()->addHours(24);
    $user->save();

    // Optional: send email
    Mail::to($user->email)->send(new FinanceWelcomeMail($user, $plainPassword));

    return back()->with('success', 'Finance user created successfully');
}
}
