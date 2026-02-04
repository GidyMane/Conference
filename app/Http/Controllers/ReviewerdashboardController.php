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
        $user = auth()->user();

        if ($user->password_setup_token !== null) {
            return redirect()->route('reviewer.password.change');
        }

        $reviewer = $user->reviewer;

        // =============================
        // FETCH ASSIGNED ABSTRACTS
        // =============================
        $assignedAbstractsQuery = \App\Models\SubmittedAbstract::query()
            ->where('status', 'UNDER_REVIEW')
            ->whereHas('assignments', function ($q) use ($user) {
                $q->where('reviewer_id', $user->id);
            });

        // =============================
        // STATS
        // =============================
        $stats = [
            'total_assigned' => \App\Models\AbstractAssignment::where(
                                    'reviewer_id',
                                    auth()->id()
                                )->count(),

            'pending_review' => \App\Models\SubmittedAbstract::whereHas('assignments', function ($q) use ($user) {
                $q->where('reviewer_id', $user->id);
            })->where('status', 'UNDER_REVIEW')->count(),

            'completed' => \App\Models\AbstractReview::where('reviewer_id', $user->id)->count(),

            'approved' => \App\Models\AbstractReview::where('reviewer_id', $user->id)
                ->where('decision', 'APPROVED')->count(),

            'rejected' => \App\Models\AbstractReview::where('reviewer_id', $user->id)
                ->where('decision', 'REJECTED')->count(),
                
        ];

        $stats['completion_rate'] = $stats['total_assigned'] > 0
            ? round(($stats['completed'] / $stats['total_assigned']) * 100)
            : 0;

        // =============================
        // RECENT ASSIGNED (LATEST FIRST)
        // =============================
        /*$recentAbstracts = \App\Models\SubmittedAbstract::with('subTheme')
            ->where('status', 'UNDER_REVIEW')
            ->whereHas('assignments', function ($q) use ($user) {
                $q->where('reviewer_id', $user->id);
            })
            ->latest('updated_at')
            ->take(5)
            ->get();*/
            
        $recentAbstracts = \App\Models\SubmittedAbstract::with([
                'subTheme',
                'latestReview' => function ($q) use ($user) {
                    $q->where('reviewer_id', $user->id);
                }
            ])
            ->where('status', 'UNDER_REVIEW')
            ->whereHas('assignments', function ($q) use ($user) {
                $q->where('reviewer_id', $user->id);
            })
            ->latest('updated_at')
            ->take(5)
            ->get();
        return view('reviewer.dashboard', compact(
            'stats',
            'recentAbstracts'
        ));
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
        $existingReview = null; // No existing review

        return view('reviewer.assignments.show', compact('assignment', 'existingReview'));
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'abstract_id' => 'required|exists:submitted_abstracts,id',
            'decision' => 'required|in:APPROVED,REJECTED',
            'comment' => 'required|string|min:10',
        ]);

        $reviewerId = auth()->id();
        $abstractId = $request->abstract_id;

        // Check if reviewer already submitted a review for this abstract
        $existingReview = \App\Models\AbstractReview::where([
            ['abstract_id', $abstractId],
            ['reviewer_id', $reviewerId]
        ])->first();

        if ($existingReview) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already submitted a review for this abstract.'
            ], 400);
        }

        // Save the review
        $review = \App\Models\AbstractReview::create([
            'abstract_id' => $abstractId,
            'reviewer_id' => $reviewerId,
            'comment' => $request->comment,
            'decision' => $request->decision,
            'reviewed_at' => now(),
        ]);

        // Optionally, update abstract status if all reviewers have submitted
        $abstract = \App\Models\SubmittedAbstract::find($abstractId);

        $totalAssignments = $abstract->assignments()->count();
        $totalReviews = $abstract->reviews()->count();

        if ($totalReviews >= $totalAssignments) {
            // If all assigned reviewers reviewed, update status to REVIEWED
            $abstract->status = 'UNDER_REVIEW';
            $abstract->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully.'
        ]);
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

    public function create()
    {
        $subthemes = SubTheme::orderBy('full_name')->get();
        $users = User::with('reviewer.subTheme')
        ->withCount([
            'assignedAbstracts',                     // adds assigned_abstracts_count
            'reviews as completed_reviews_count'     // adds completed_reviews_count
        ])
        ->get();

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
        try {
            $validated = $request->validate([
                'full_name'   => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'subtheme_id' => 'required|exists:sub_themes,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        }

        $plainPassword = Str::random(10);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($plainPassword),
            'role'      => 'REVIEWER',
            'is_active' => true,
            'password_setup_token' => Str::uuid(),
            'password_setup_expires_at' => now()->addHours(24),
        ]);

        Reviewer::create([
            'user_id'      => $user->id,
            'sub_theme_id' => $validated['subtheme_id'],
        ]);

        try {
            Mail::to($user->email)->send(
                new \App\Mail\UserWelcomeMail($user, $plainPassword)
            );
        } catch (\Throwable $e) {
            \Log::error('Welcome email failed', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
        ]);
    }




}