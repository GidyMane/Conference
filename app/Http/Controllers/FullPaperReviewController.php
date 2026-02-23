<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FullPaperReviewController extends Controller
{
    /**
     * Dashboard - dummy papers
     */
    public function index()
    {
        $papers = collect([
            (object)[
                'id' => 1,
                'title' => 'AI in Agriculture',
                'author' => 'John Doe',
                'review_status' => 'pending_assignment',
                'abstract' => (object)[
                    'subTheme' => (object)['name' => 'Technology']
                ],
                'assignments' => [],
                'reviews' => [],
                'decision' => null,
            ],
            (object)[
                'id' => 2,
                'title' => 'Climate Change Impact',
                'author' => 'Jane Smith',
                'review_status' => 'under_review',
                'abstract' => (object)[
                    'subTheme' => (object)['name' => 'Environment']
                ],
                'assignments' => [],
                'reviews' => [],
                'decision' => null,
            ],
            (object)[
                'id' => 3,
                'title' => 'Blockchain in Healthcare',
                'author' => 'Michael Brown',
                'review_status' => 'awaiting_decision',
                'abstract' => (object)[
                    'subTheme' => (object)['name' => 'HealthTech']
                ],
                'assignments' => [],
                'reviews' => [],
                'decision' => null,
            ],
        ]);

        $stats = [
            'total_papers' => 3,
            'pending_assignment' => 1,
            'under_review' => 1,
            'awaiting_decision' => 1,
            'approved' => 0,
            'rejected' => 0,
        ];

        return view('subtheme-leader.fullpapers.index', compact('papers', 'stats'));
    }

    /**
     * Show all reviews for a paper
     */
    public function showPaperReviews($id)
    {
        $paper = (object)[
            'id' => $id,
            'title' => 'AI in Agriculture',
            'abstract' => (object)[
                'subTheme' => (object)['name' => 'Technology']
            ],
            'assignments' => [
                (object)[
                    'reviewer' => (object)['name' => 'Dr Alice']
                ],
                (object)[
                    'reviewer' => (object)['name' => 'Prof Bob']
                ],
            ],
            'reviews' => [
                (object)[
                    'reviewer' => (object)['name' => 'Dr Alice'],
                    'score' => 85,
                    'comments' => 'Very good work'
                ],
                (object)[
                    'reviewer' => (object)['name' => 'Prof Bob'],
                    'score' => 88,
                    'comments' => 'Strong methodology'
                ],
            ],
            'decision' => null,
        ];

        $reviewSummary = [
            'average_score' => 86.5,
            'recommendation' => 'Accept with Minor Revisions',
        ];

        return view('subtheme-leader.fullpapers.decision', compact('paper', 'reviewSummary'));
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