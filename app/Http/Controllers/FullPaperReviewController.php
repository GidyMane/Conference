<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FullPaper;
use App\Models\PrequalifiedReviewer;
use App\Models\ReviewAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ReviewAssignmentMail;

class FullPaperReviewController extends Controller
{
    /**
     * Dashboard - dummy papers
     */
    public function index()
    {
        $reviewerId = auth()->id();

        // Fetch papers in this subtheme
        $papers = FullPaper::with(['abstract.subTheme'])
            ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId);
            })
            ->latest()
        ->get();

        // Stats
        $stats = [
            'pending_assignment' => $papers->where('status', 'pending_assignment')->count(),
            'under_review' => $papers->where('status', 'under_review')->count(),
            'awaiting_decision' => $papers->where('status', 'awaiting_decision')->count(),
            'completed' => $papers->whereIn('status', ['approved', 'rejected'])->count(),
        ];

        return view('reviewer.fullpapers-review', compact('papers', 'stats'));
    }

    /**
     * Show all reviews for a paper
     */
public function showAssignForm($id)
{
    $reviewerId = auth()->id();

    // ✅ Get the paper FIRST
    $paper = FullPaper::with(['abstract.subTheme'])
        ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
            $q->where('reviewer_id', $reviewerId);
        })
        ->findOrFail($id);

    $subThemeId = $paper->abstract->sub_theme_id ?? null;

    /*
    |--------------------------------------------------------------------------
    | 1️⃣ PREQUALIFIED REVIEWERS (MAX 3 ACTIVE)
    |--------------------------------------------------------------------------
    */

    // Get prequalified reviewers already at capacity
    $prequalifiedAtCapacity = ReviewAssignment::whereNotNull('prequalified_reviewer_id')
        ->whereIn('status', ['pending', 'started'])
        ->select('prequalified_reviewer_id')
        ->groupBy('prequalified_reviewer_id')
        ->havingRaw('COUNT(*) >= 3')
        ->pluck('prequalified_reviewer_id');

    $prequalifiedReviewers = PrequalifiedReviewer::where('sub_theme_id', $subThemeId)
    ->whereNotIn('id', $prequalifiedAtCapacity)
    ->withCount([
        'assignments as assigned_count' => function ($q) {
            $q->whereIn('status', ['pending', 'started']);
        }
    ])
    ->get();

    /*
    |--------------------------------------------------------------------------
    | 2️⃣ PEER REVIEWERS (AUTHORS WITH FULL PAPERS, MAX 3 ACTIVE)
    |--------------------------------------------------------------------------
    */

    // Peer reviewers already at capacity
    $peerAtCapacity = ReviewAssignment::whereNotNull('peer_reviewer_id')
        ->whereIn('status', ['pending', 'started'])
        ->select('peer_reviewer_id')
        ->groupBy('peer_reviewer_id')
        ->havingRaw('COUNT(*) >= 3')
        ->pluck('peer_reviewer_id');

    $currentAuthorEmail = $paper->abstract->author_email;

    $peerReviewers = User::where('role', 'AUTHOR')
        ->whereNotIn('id', $peerAtCapacity)
        ->whereHas('submittedAbstracts.fullPaper')
        ->where('email', '!=', $currentAuthorEmail)
        ->select('id', 'full_name', 'email')
        ->orderBy('full_name')
        ->get();

    return view('reviewer.fullpapers-assign', compact(
        'paper',
        'prequalifiedReviewers',
        'peerReviewers'
    ));
}

    /**
     * Show individual review details
     */
    public function showReviewDetails($reviewId)
    {
        $review = (object)[
            'id' => $reviewId,
            'reviewer' => (object)['name' => 'Dr Alice'],
            'comments' => 'Excellent contribution to the field.',
            'score' => 90,
        ];

        $sectionScores = [
            'Introduction' => 9,
            'Literature Review' => 8,
            'Methodology' => 9,
            'Results' => 9,
            'Conclusion' => 8,
        ];

        return view('admin.fullpapers.review-details', compact('review', 'sectionScores'));
    }

    /**
     * Dummy prequalified reviewers
     */
    public function prequalifiedReviewers()
    {
        $reviewers = collect([
            (object)[
                'id' => 1,
                'user' => (object)['name' => 'Dr Alice'],
                'is_active' => true,
                'current_assigned_count' => 2,
            ],
            (object)[
                'id' => 2,
                'user' => (object)['name' => 'Prof Bob'],
                'is_active' => true,
                'current_assigned_count' => 1,
            ],
            (object)[
                'id' => 3,
                'user' => (object)['name' => 'Dr Carol'],
                'is_active' => false,
                'current_assigned_count' => 0,
            ],
        ]);

        $stats = [
            'total' => 3,
            'active' => 2,
            'available' => 2,
            'at_capacity' => 0,
        ];

        return view('admin.reviewers.prequalified', compact('reviewers', 'stats'));
    }

    /**
     * Add reviewer (dummy)
     */
    public function addPrequalifiedReviewer(Request $request)
    {
        return back()->with('success', 'Dummy reviewer added successfully.');
    }

    /**
     * Update reviewer (dummy)
     */
    public function updatePrequalifiedReviewer(Request $request, $id)
    {
        return back()->with('success', 'Dummy reviewer updated successfully.');
    }

    /**
     * Toggle reviewer status (dummy)
     */
    public function toggleReviewerStatus($id)
    {
        return back()->with('success', 'Dummy reviewer status toggled.');
    }

    /**
     * Workload statistics (dummy)
     */
    public function workloadStatistics()
    {
        $reviewers = collect([
            (object)[
                'name' => 'Dr Alice',
                'total_assigned' => 3,
                'pending' => 1,
                'completed' => 2,
            ],
            (object)[
                'name' => 'Prof Bob',
                'total_assigned' => 2,
                'pending' => 0,
                'completed' => 2,
            ],
        ]);

        return view('admin.reviewers.workload', compact('reviewers'));
    }

    /**
     * Export reviews (dummy)
     */
    public function exportReviews($paperId)
    {
        $paper = (object)[
            'id' => $paperId,
            'title' => 'AI in Agriculture',
            'reviews' => [],
            'abstract' => (object)['title' => 'AI Abstract']
        ];

        return view('subtheme-leader.fullpapers.index', compact('paper'));
    }

    /**
     * Admin assign form (dummy)
     */
    public function showAdminAssignForm($id)
    {
        $paper = (object)[
            'id' => $id,
            'title' => 'AI in Agriculture',
            'assignments' => []
        ];

        $prequalifiedReviewers = collect([
            (object)['name' => 'Dr Alice'],
            (object)['name' => 'Prof Bob'],
        ]);

        $peerReviewers = collect([
            (object)['name' => 'Researcher One'],
            (object)['name' => 'Researcher Two'],
        ]);

        return view('subtheme-leader.fullpapers.assign', compact('paper', 'prequalifiedReviewers', 'peerReviewers'));
    }

    /**
     * Force reassign (dummy)
     */
    public function forceReassign(Request $request, $assignmentId)
    {
        return back()->with('success', 'Dummy assignment removed.');
    }

    public function assignReviewers(Request $request, $paperId)
    {
        $request->validate([
            'reviewer1' => 'required',
            'reviewer2' => 'required|different:reviewer1',
            'reviewer3' => 'required|different:reviewer1|different:reviewer2',
        ]);

        $paper = FullPaper::findOrFail($paperId);

        $assignments = [];

        // Prequalified reviewer
        $prequalified = PrequalifiedReviewer::find($request->reviewer1);

        $assignments[] = ReviewAssignment::create([
            'full_paper_id' => $paper->id,
            'prequalified_reviewer_id' => $prequalified->id,
            'review_token' => Str::uuid(),
            'status' => 'pending'
        ]);

        // Peer reviewers
        foreach (['reviewer2', 'reviewer3'] as $field) {

            $user = User::find($request->$field);

            $assignments[] = ReviewAssignment::create([
                'full_paper_id' => $paper->id,
                'peer_reviewer_id' => $user->id,
                'review_token' => Str::uuid(),
                'status' => 'pending'
            ]);
        }

        // Send emails
        foreach ($assignments as $assignment) {

            $email = $assignment->prequalified_reviewer_id
                ? $assignment->prequalifiedReviewer->email
                : $assignment->peerReviewer->email;

            Mail::to($email)->send(
                new ReviewAssignmentMail($assignment)
            );
        }

        return redirect()
            ->route('reviewer.fullpapers.index')
            ->with('success', 'Reviewers assigned and emails sent.');
    }

    /**
     * List all papers that have completed all 3 reviews — awaiting leader decision
     */
    public function completedReviews()
    {
        return view('reviewer.fullpapers-completed');
    }

    /**
     * Show all 3 reviews for a specific paper + decision form
     */
    public function allReviews($id)
    {
        return view('reviewer.fullpapers-all-reviews', ['paperId' => $id]);
    }

    /**
     * Sub-theme leader submits final decision (approve / reject)
     */
    public function submitFinalDecision(Request $request, $id)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected',
            'comments' => 'required|min:30',
        ]);

        // TODO: persist decision and notify author
        // FullPaper::findOrFail($id)->update([...]);

        return redirect()
            ->route('reviewer.fullpapers.completed')
            ->with('success', 'Decision submitted and author notified successfully.');
    }

}