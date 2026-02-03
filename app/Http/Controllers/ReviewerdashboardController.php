<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\SubTheme;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Reviewer;

class ReviewerDashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->password_setup_token !== null) {
            return redirect()->route('reviewer.password.change');
        }

        // Get reviewer from session (dummy data)
        $reviewer = (object) session('reviewer_user', [
            'id' => 1,
            'name' => 'Dr. John Kamau',
            'email' => 'reviewer@kalro.org',
            'sub_theme_name' => 'Climate-Smart Agriculture',
            'password_changed' => true
        ]);

        // Dummy statistics
        $stats = [
            'total_assigned' => 5,
            'pending' => 2,
            'under_review' => 1,
            'completed' => 2,
        ];

        // Dummy assignments
        $assignments = [
            (object)[
                'id' => 1,
                'status' => 'assigned',
                'assigned_at' => new \DateTime('2026-01-30 10:00:00'),
                'abstract' => (object)[
                    'id' => 1,
                    'submission_id' => 'SUB01-087',
                    'title' => 'Climate-Resilient Maize Varieties for Semi-Arid Regions',
                    'subTheme' => (object)['code' => 'CSA-01', 'name' => 'Climate-Smart Agriculture']
                ]
            ],
            (object)[
                'id' => 2,
                'status' => 'under_review',
                'assigned_at' => new \DateTime('2026-01-28 14:30:00'),
                'abstract' => (object)[
                    'id' => 2,
                    'submission_id' => 'SUB01-085',
                    'title' => 'Water Harvesting Technologies for Small-Scale Farmers',
                    'subTheme' => (object)['code' => 'CSA-01', 'name' => 'Climate-Smart Agriculture']
                ]
            ],
            (object)[
                'id' => 3,
                'status' => 'assigned',
                'assigned_at' => new \DateTime('2026-01-25 09:15:00'),
                'abstract' => (object)[
                    'id' => 3,
                    'submission_id' => 'SUB01-082',
                    'title' => 'Drought-Tolerant Sorghum Production in Arid Lands',
                    'subTheme' => (object)['code' => 'CSA-01', 'name' => 'Climate-Smart Agriculture']
                ]
            ],
            (object)[
                'id' => 4,
                'status' => 'reviewed',
                'assigned_at' => new \DateTime('2026-01-22 11:00:00'),
                'abstract' => (object)[
                    'id' => 4,
                    'submission_id' => 'SUB01-078',
                    'title' => 'Conservation Agriculture Practices in Western Kenya',
                    'subTheme' => (object)['code' => 'CSA-01', 'name' => 'Climate-Smart Agriculture']
                ]
            ],
            (object)[
                'id' => 5,
                'status' => 'reviewed',
                'assigned_at' => new \DateTime('2026-01-20 15:45:00'),
                'abstract' => (object)[
                    'id' => 5,
                    'submission_id' => 'SUB01-075',
                    'title' => 'Climate Information Services for Farmers',
                    'subTheme' => (object)['code' => 'CSA-01', 'name' => 'Climate-Smart Agriculture']
                ]
            ],
        ];

        return view('reviewer.dashboard', compact('stats', 'assignments'));
    }

    public function assignments(Request $request)
    {
        // Dummy assignments with filtering
        $assignments = [
            (object)[
                'id' => 1,
                'status' => 'assigned',
                'assigned_at' => new \DateTime('2026-01-30 10:00:00'),
                'abstract' => (object)[
                    'submission_id' => 'SUB01-087',
                    'title' => 'Climate-Resilient Maize Varieties for Semi-Arid Regions',
                    'subTheme' => (object)['code' => 'CSA-01']
                ]
            ],
            (object)[
                'id' => 2,
                'status' => 'under_review',
                'assigned_at' => new \DateTime('2026-01-28 14:30:00'),
                'abstract' => (object)[
                    'submission_id' => 'SUB01-085',
                    'title' => 'Water Harvesting Technologies for Small-Scale Farmers',
                    'subTheme' => (object)['code' => 'CSA-01']
                ]
            ],
        ];

        return view('reviewer.assignments.index', compact('assignments'));
    }

    public function showAbstract($assignmentId)
    {
        // Dummy assignment details
        $assignment = (object)[
            'id' => $assignmentId,
            'status' => 'assigned',
            'assigned_at' => new \DateTime('2026-01-30 10:00:00'),
            'abstract' => (object)[
                'id' => 1,
                'submission_id' => 'SUB01-087',
                'title' => 'Climate-Resilient Maize Varieties for Semi-Arid Regions of Kenya',
                'abstract_text' => 'Climate change poses significant challenges to maize production in Kenya\'s semi-arid regions. This study evaluates the performance of climate-resilient maize varieties developed through conventional breeding and biotechnology approaches. Field trials were conducted across three agro-ecological zones over two seasons. Results indicate that drought-tolerant varieties increased yields by 30-45% compared to traditional varieties under water-stressed conditions. The varieties also showed improved resistance to common pests and diseases. Recommendations for scaling up adoption among smallholder farmers are discussed.',
                'keywords' => 'climate change, drought tolerance, maize breeding, food security, Kenya',
                'submission_type' => 'Research Paper',
                'presentation_preference' => 'Oral Presentation',
                'preferred_attendance_mode' => 'In-person',
                'special_requirements' => null,
                'subTheme' => (object)[
                    'code' => 'CSA-01',
                    'name' => 'Climate-Smart Agriculture'
                ],
                'correspondingAuthor' => (object)[
                    'full_name' => 'Dr. Jane Mwangi',
                    'email' => 'j.mwangi@kalro.org',
                    'phone_number' => '+254728463410',
                    'organization' => 'Kenya Agricultural and Livestock Research Organization',
                    'department' => 'Crop Research',
                    'position' => 'Senior Research Scientist'
                ],
                'coAuthors' => [
                    (object)[
                        'author_name' => 'Prof. Samuel Ochieng',
                        'institution' => 'University of Nairobi'
                    ],
                    (object)[
                        'author_name' => 'Dr. Mary Wanjiku',
                        'institution' => 'JKUAT'
                    ]
                ]
            ]
        ];

        $existingReview = null; // No existing review

        return view('reviewer.assignments.show', compact('assignment', 'existingReview'));
    }

    public function submitReview(Request $request, $assignmentId)
    {
        $validated = $request->validate([
            'decision' => 'required|in:approved,rejected,needs_revision',
            'comments' => 'required|string|min:50',
            'relevance_score' => 'required|integer|min:1|max:5',
            'methodology_score' => 'required|integer|min:1|max:5',
            'originality_score' => 'required|integer|min:1|max:5',
            'clarity_score' => 'required|integer|min:1|max:5',
        ]);

        // In real implementation, save to database
        // For now, just show success message

        return redirect()->route('reviewer.dashboard')
            ->with('success', 'Review submitted successfully! Thank you for your contribution.');
    }

    public function profile()
    {
        $reviewer = (object) session('reviewer_user', [
            'id' => 1,
            'name' => 'Dr. John Kamau',
            'email' => 'reviewer@kalro.org',
            'organization' => 'University of Nairobi',
            'expertise' => 'Climate-Smart Agriculture, Sustainable Farming Systems',
            'sub_theme_name' => 'Climate-Smart Agriculture'
        ]);

        return view('reviewer.profile.show', compact('reviewer'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'expertise' => 'nullable|string',
        ]);

        // Update session data
        $reviewer = session('reviewer_user');
        $reviewer['full_name'] = $validated['full_name'];
        $reviewer['organization'] = $validated['organization'] ?? '';
        $reviewer['expertise'] = $validated['expertise'] ?? '';
        session(['reviewer_user' => $reviewer]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        return view('reviewer.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // In dummy mode, just accept any current password
        // In real implementation, verify against database

        // Update session to mark password as changed
        $reviewer = session('reviewer_user');
        $reviewer['password_changed'] = true;
        session(['reviewer_user' => $reviewer]);

        return redirect()->route('reviewer.dashboard')
            ->with('success', 'Password changed successfully.');
    }

    public function create()
    {
        $subthemes = SubTheme::orderBy('full_name')->get();
        $users = User::with('reviewer.subTheme')->get();

        $stats = [
            'total_users'       => User::count(),
            'active_reviewers'  => User::where('role', 'REVIEWER')->count(),
            'admins'            => User::where('role', 'ADMIN')->count(),
            'pending_setup'     => User::whereNotNull('password_setup_token')->count(),
        ];

        return view('admin.users.index', compact(
            'subthemes',
            'users',
            'stats'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'subtheme_id'=> 'required|exists:sub_themes,id',
        ]);

        // Generate one-time password
        $plainPassword = Str::random(10);

        // Create user
        $user = User::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'password'  => Hash::make($plainPassword),
            'role'      => 'REVIEWER', // enforced
            'is_active' => true,
            'password_setup_token' => Str::uuid(),
            'password_setup_expires_at' => now()->addHours(24),
        ]);

        // Assign reviewer sub-theme
        if ($user->role === 'REVIEWER') {
            Reviewer::create([
                'user_id'      => $user->id,
                'sub_theme_id' => $request->subtheme_id,
            ]);
        }

        // Attempt to send email
        try {
            Mail::to($user->email)->send(
                new \App\Mail\UserWelcomeMail($user, $plainPassword)
            );

            return redirect()->back()->with('success', 'User created successfully and email sent!');
        } catch (\Throwable $e) {
            \Log::error('Welcome email failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('warning', 'User created successfully, but welcome email failed to send.');
        }
    }
}