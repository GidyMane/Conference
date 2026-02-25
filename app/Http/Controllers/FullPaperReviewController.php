<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FullPaper;
use App\Models\PrequalifiedReviewer;
use App\Models\ReviewAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    // ✅ Get sub_theme_id properly
    $subThemeId = $paper->abstract->sub_theme_id ?? null;

    // ✅ Fetch prequalified reviewers for that subtheme
    $prequalifiedReviewers = PrequalifiedReviewer::where('sub_theme_id', $subThemeId)
        ->withCount([
            'assignments as assigned_count' => function ($q) {
                $q->whereIn('status', ['pending', 'started']);
            }
        ])
        ->get()
        ->filter(function ($reviewer) {
            return $reviewer->assigned_count < 3;
        });

    // ✅ Peer authors
    $peerReviewers = User::where('role', 'author')->get();

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
}