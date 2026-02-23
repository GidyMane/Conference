<?php

namespace App\Http\Controllers;

use App\Models\FullPaper;
use App\Models\FullPaperAssignment;
use App\Models\FullPaperReview;
use App\Models\PrequalifiedReviewer;
use App\Notifications\AllReviewsComplete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicReviewController extends Controller
{
    /**
     * Show review form via unique token
     */
    public function showReviewForm($token)
    {
        $assignment = FullPaperAssignment::where('review_token', $token)
            ->where('status', '!=', 'completed')
            ->where('token_expires_at', '>', now())
            ->with(['fullPaper.abstract.subTheme', 'reviewer'])
            ->firstOrFail();

        $paper = $assignment->fullPaper;
        $reviewer = $assignment->reviewer;

        // Check if review already exists
        $existingReview = FullPaperReview::where('assignment_id', $assignment->id)->first();

        // Mark as in progress if just assigned
        if ($assignment->status === 'assigned') {
            $assignment->markAsStarted();
        }

        return view('review.fullpaper-form', compact('assignment', 'paper', 'reviewer', 'token', 'existingReview'));
    }

    /**
     * Download full paper PDF
     */
    public function downloadPaper($token)
    {
        $assignment = FullPaperAssignment::where('review_token', $token)
            ->where('token_expires_at', '>', now())
            ->firstOrFail();

        $paper = $assignment->fullPaper;

        if (!$paper->paper_file_path || !Storage::exists($paper->paper_file_path)) {
            abort(404, 'Paper file not found');
        }

        return Storage::download($paper->paper_file_path);
    }

    /**
     * Submit review
     */
    public function submitReview(Request $request, $token)
    {
        $assignment = FullPaperAssignment::where('review_token', $token)
            ->where('status', '!=', 'completed')
            ->where('token_expires_at', '>', now())
            ->firstOrFail();

        $validated = $request->validate([
            // Recommendation
            'recommendation' => 'required|in:accept,needs_major_revisions,needs_minor_revisions,reject',
            'paper_suitability' => 'required|in:oral_presentation,poster_presentation,conference_powerpoint_presentation',
            
            // Section 1: Title
            'title_appropriate' => 'required|integer|min:0|max:2',
            'title_reflects_content' => 'required|integer|min:0|max:3',
            'title_comments' => 'nullable|string',
            
            // Section 2: Abstract
            'abstract_word_count' => 'required|integer|min:0|max:2',
            'abstract_completeness' => 'required|integer|min:0|max:3',
            'abstract_comments' => 'nullable|string',
            
            // Section 3: Introduction
            'intro_background' => 'required|integer|min:0|max:3',
            'intro_originality' => 'required|integer|min:0|max:5',
            'intro_objectives' => 'required|integer|min:0|max:2',
            'intro_comments' => 'nullable|string',
            
            // Section 4: Methods
            'methods_replication' => 'required|integer|min:0|max:10',
            'methods_design' => 'required|integer|min:0|max:5',
            'methods_statistics' => 'required|integer|min:0|max:5',
            'methods_ethics' => 'required|integer|min:0|max:5',
            'methods_comments' => 'nullable|string',
            
            // Section 5: Results
            'results_insights' => 'required|integer|min:0|max:5',
            'results_narrative' => 'required|integer|min:0|max:5',
            'results_data_clarity' => 'required|integer|min:0|max:8',
            'results_visuals' => 'required|integer|min:0|max:5',
            'results_referencing' => 'required|integer|min:0|max:2',
            'results_comments' => 'nullable|string',
            
            // Section 6: Discussion
            'discussion_context' => 'required|integer|min:0|max:2',
            'discussion_objectives' => 'required|integer|min:0|max:2',
            'discussion_significance' => 'required|integer|min:0|max:5',
            'discussion_theme' => 'required|integer|min:0|max:2',
            'discussion_references' => 'required|integer|min:0|max:4',
            'discussion_comments' => 'nullable|string',
            
            // Section 7: Conclusions
            'conclusion_objectives' => 'required|integer|min:0|max:2',
            'conclusion_consistency' => 'required|integer|min:0|max:5',
            'conclusion_contribution' => 'required|integer|min:0|max:3',
            'conclusion_comments' => 'nullable|string',
            
            // Section 8: References
            'references_accuracy' => 'required|integer|min:0|max:2',
            'references_balance' => 'required|integer|min:0|max:1',
            'references_citation' => 'required|integer|min:0|max:1',
            'references_matching' => 'required|integer|min:0|max:1',
            'references_comments' => 'nullable|string',
            
            // Overall
            'overall_comments' => 'required|string|min:50',
        ]);

        // Create or update review
        $review = FullPaperReview::updateOrCreate(
            [
                'full_paper_id' => $assignment->full_paper_id,
                'reviewer_id' => $assignment->reviewer_id,
                'assignment_id' => $assignment->id,
            ],
            array_merge($validated, [
                'status' => 'completed',
                'reviewed_at' => now(),
            ])
        );

        // Mark assignment as completed
        $assignment->markAsCompleted();

        // Update prequalified reviewer count if applicable
        if ($assignment->reviewer_type === 'prequalified') {
            $prequalified = PrequalifiedReviewer::where('user_id', $assignment->reviewer_id)->first();
            if ($prequalified && $prequalified->current_assigned_count > 0) {
                $prequalified->decrementAssignedCount();
            }
        }

        // Update paper review status
        $assignment->fullPaper->updateReviewStatus();

        // Check if all 3 reviews complete - notify sub-theme leader
        if ($assignment->fullPaper->hasAllReviewsComplete()) {
            $subthemeLeader = $assignment->fullPaper->abstract->subTheme->leader; // Assuming relation exists
            if ($subthemeLeader) {
                $subthemeLeader->notify(new AllReviewsComplete($assignment->fullPaper));
            }
        }

        return view('review.success', [
            'paper' => $assignment->fullPaper,
            'totalScore' => $review->total_score
        ]);
    }
}