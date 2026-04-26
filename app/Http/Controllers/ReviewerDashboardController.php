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
use Illuminate\Support\Facades\DB;
use App\Models\SubmittedAbstract;
use App\Models\AbstractAssignment;
use App\Models\AbstractReview;
use App\Models\ConferenceRegistration;
use App\Models\GroupRegistration;
use App\Models\ExhibitionRegistration;
use Illuminate\Support\Facades\Auth;

class ReviewerDashboardController extends Controller
{
public function index()
{
    $user = auth()->user();

    /**
     * FINANCE DASHBOARD
     */
if ($user->role === 'FINANCE') {

    $stats = [
        'total_registrations' => ConferenceRegistration::count() + GroupRegistration::count(),
        'pending_registrations' => ConferenceRegistration::where('payment_status', 'pending')->count()
            + GroupRegistration::where('payment_status', 'pending')->count(),
        'approved_registrations' => ConferenceRegistration::where('payment_status', 'approved')->count()
            + GroupRegistration::where('payment_status', 'approved')->count(),
        'rejected_registrations' => ConferenceRegistration::where('payment_status', 'rejected')->count()
            + GroupRegistration::where('payment_status', 'rejected')->count(),

        'total_exhibitions' => ExhibitionRegistration::count(),
        'pending_exhibitions' => ExhibitionRegistration::where('status', 'pending')->count(),
        'approved_exhibitions' => ExhibitionRegistration::where('status', 'approved')->count(),
        'rejected_exhibitions' => ExhibitionRegistration::where('status', 'rejected')->count(),
    ];

    $recentRegistrations = collect();

    // Individual registrations
    $conference = ConferenceRegistration::latest()->take(5)->get()->map(function ($item) {
        return (object) [
            'reference' => $item->ticket_number ?? ('CONF-' . $item->id),
            'name' => $item->first_name . ' ' . $item->last_name,
            'type' => 'conference',
            'amount' => $item->fee,
            'currency' => $item->fee_currency,
            'status' => $item->payment_status,
            'created_at' => $item->created_at,
        ];
    });

    // Group registrations
    $groups = GroupRegistration::latest()->take(5)->get()->map(function ($item) {
        return (object) [
            'reference' => 'GROUP-' . $item->id,
            'name' => $item->first_name . ' ' . $item->last_name,
            'type' => 'group',
            'amount' => $item->total_fee,
            'currency' => $item->currency,
            'status' => $item->payment_status,
            'created_at' => $item->created_at,
        ];
    });

    // Exhibitions
    $exhibitions = ExhibitionRegistration::latest()->take(5)->get()->map(function ($item) {
        return (object) [
            'reference' => $item->reference_number,
            'name' => $item->organization_name,
            'type' => 'exhibition',
            'amount' => $item->total_amount,
            'currency' => 'KES',
            'status' => $item->status,
            'created_at' => $item->created_at,
        ];
    });

    $recentRegistrations = $conference
        ->merge($groups)
        ->merge($exhibitions)
        ->sortByDesc('created_at')
        ->take(10)
        ->values();

    return view('reviewer.dashboard', [
        'stats' => $stats,
        'recentRegistrations' => $recentRegistrations,
        'recentAbstracts' => collect(),
    ]);
}

    /**
     * REVIEWER DASHBOARD
     */
    if ($user->role === 'TEMP_REVIEWER') {
        // TEMP_REVIEWER: abstracts in their subtheme
        $subThemeId = $user->tempReviewer->sub_theme_id ?? null;

        $abstractsQuery = SubmittedAbstract::where('sub_theme_id', $subThemeId);

        $pendingReviewsCount = (clone $abstractsQuery)
            ->where('status', 'UNDER_REVIEW')
            ->count();

        $completedReviewsCount = (clone $abstractsQuery)
            ->whereIn('status', ['APPROVED', 'REJECTED', 'REVIEWED'])
            ->count();

        $approved = AbstractReview::whereHas('abstract', function ($q) use ($subThemeId) {
                $q->where('sub_theme_id', $subThemeId);
            })
            ->where('decision', 'APPROVED')
            ->count();

        $rejected = AbstractReview::whereHas('abstract', function ($q) use ($subThemeId) {
                $q->where('sub_theme_id', $subThemeId);
            })
            ->where('decision', 'REJECTED')
            ->count();

        $needsRevision = AbstractReview::whereHas('abstract', function ($q) use ($subThemeId) {
                $q->where('sub_theme_id', $subThemeId);
            })
            ->where('decision', 'NEEDS_REVISION')
            ->count();

        $totalAssigned = $pendingReviewsCount + $completedReviewsCount;

        $completionRate = $totalAssigned > 0
            ? round(($completedReviewsCount / $totalAssigned) * 100)
            : 0;

    } else {
        // Regular reviewer: abstracts assigned to them
        $abstractsQuery = SubmittedAbstract::whereHas('assignments', function ($q) use ($user) {
            $q->where('reviewer_id', $user->id);
        });

        $abstractIds = $abstractsQuery->pluck('id');

        $reviewQuery = AbstractReview::where('reviewer_id', $user->id)
            ->whereIn('abstract_id', $abstractIds);

        $totalAssigned = $abstractIds->count();
        $completedReviewsCount = $reviewQuery->count();
        $pendingReviewsCount = max($totalAssigned - $completedReviewsCount, 0);

        $approved = (clone $reviewQuery)->where('decision', 'APPROVED')->count();
        $rejected = (clone $reviewQuery)->where('decision', 'REJECTED')->count();
        $needsRevision = (clone $reviewQuery)->where('decision', 'NEEDS_REVISION')->count();

        $completionRate = $totalAssigned > 0
            ? round(($completedReviewsCount / $totalAssigned) * 100)
            : 0;
    }

    $stats = [
        'total_assigned' => $totalAssigned,
        'pending_review' => $pendingReviewsCount,
        'completed' => $completedReviewsCount,
        'approved' => $approved,
        'rejected' => $rejected,
        'needs_revision' => $needsRevision,
        'completion_rate' => $completionRate,
    ];

    $recentAbstracts = (clone $abstractsQuery)
        ->with(['subTheme', 'latestReview'])
        ->latest()
        ->limit(5)
        ->get();

    return view('reviewer.dashboard', [
        'stats' => $stats,
        'recentAbstracts' => $recentAbstracts
    ]);
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
        $users = User::with('reviewer.subThemes')
            ->withCount([
                'assignedAbstracts',                    
                'reviews as completed_reviews_count'
            ])
            ->get();

        $stats = [
            'total_users'       => User::count(),
            'active_reviewers' => User::where('role', 'REVIEWER')
                           ->where('is_active', 1)
                           ->count(),
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
    // =============================
    // VALIDATION
    // =============================
    try {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'subtheme_ids'   => 'required|array|min:1',
            'subtheme_ids.*' => 'exists:sub_themes,id',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors'  => $e->errors(),
        ], 422);
    }

    // =============================
    // GENERATE TEMP PASSWORD
    // =============================
    $plainPassword = Str::random(10);

    try {
        DB::beginTransaction();

        // =============================
        // CREATE USER
        // =============================
        $user = User::create([
            'full_name'                  => $validated['full_name'],
            'email'                      => $validated['email'],
            'password'                   => Hash::make($plainPassword),
            'role'                       => 'REVIEWER',
            'is_active'                  => true,
            'password_setup_token'       => Str::uuid(),
            'password_setup_expires_at'  => now()->addHours(24),
        ]);

        // =============================
        // CREATE REVIEWER PROFILE
        // =============================
        $reviewer = Reviewer::create([
            'user_id' => $user->id,
        ]);

        // =============================
        // ATTACH MULTIPLE SUB-THEMES
        // =============================
        $reviewer->subThemes()->sync($validated['subtheme_ids']);

        DB::commit();

    } catch (\Throwable $e) {
        DB::rollBack();

        \Log::error('Reviewer creation failed', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to create reviewer. Please try again.'
        ], 500);
    }

    // =============================
    // SEND WELCOME EMAIL (NON-BLOCKING)
    // =============================
    try {
        Mail::to($user->email)->send(
            new \App\Mail\UserWelcomeMail($user, $plainPassword)
        );
    } catch (\Throwable $e) {
        \Log::error('Welcome email failed', [
            'user_id' => $user->id,
            'error'   => $e->getMessage()
        ]);
        // Do NOT fail user creation if email fails
    }

    return response()->json([
        'success' => true,
        'message' => 'Reviewer created successfully and email sent.',
    ]);
}



    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        if (!$user->email) {
            return response()->json([
                'success' => false,
                'message' => 'User has no email address.'
            ], 400);
        }

        // Generate new temporary password
        $temporaryPassword = Str::random(10);

        // Reset credentials
        $user->update([
            'password' => Hash::make($temporaryPassword),
            'password_setup_token' => Str::uuid(),
            'password_setup_expires_at' => now()->addHours(24),
        ]);

        // Send reset email
        try {
            Mail::to($user->email)->send(
                new \App\Mail\UserPasswordResetMail($user, $temporaryPassword)
            );
        } catch (\Throwable $e) {
            \Log::error('Password reset email failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully.'
        ]);
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);

    $user->is_active = 0;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'User deactivated successfully.'
    ]);
}


}
