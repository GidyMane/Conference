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
use App\Models\FullPaperReview;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FinalDecisionMail;

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
            'pending_assignment' => $papers->where('status', 'PENDING')->count(),
            'under_review' => $papers->where('status', 'UNDER_REVIEW')->count(),
            'total' => $papers->count(),
            'completed' => $papers->whereIn('status', ['APPROVED', 'REJECTED'])->count(),
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
        ->where('email', '!=', $currentAuthorEmail)
        ->whereHas('submittedAbstracts', function ($q) use ($subThemeId) {
            $q->where('sub_theme_id', $subThemeId)
            ->whereHas('fullPaper');
        })
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

        // After creating all 3 assignments
        $paper->update([
            'status' => 'under_review',
        ]);

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
        // Get only papers with final decision 'approved' or 'rejected'
        $papers = \App\Models\FullPaper::with('reviews', 'abstract', 'abstract.subtheme')
            ->whereIn('status', ['approved', 'rejected']) // <-- filter here
            ->get();

        // Get unique sub-themes for the filter dropdown
        $subthemes = $papers->pluck('sub_theme')->unique();

        return view('reviewer.fullpapers-completed', compact('papers', 'subthemes'));
    }

    /**
     * Show all 3 reviews for a specific paper + decision form
     */
    public function allReviews($id)
    {
        $paper = FullPaper::with([
            'abstract.subTheme',
            'reviewAssignments.prequalifiedReviewer',
            'reviewAssignments.peerReviewer',
            'reviewAssignments.fullPaperReview'
        ])->findOrFail($id);

        // Instead of separate FullPaperReview query,
        // just use reviewAssignments
        $reviews = $paper->reviewAssignments;

        return view('reviewer.fullpapers-decision', compact('paper', 'reviews'));
    }

    /**
     * Sub-theme leader submits final decision (approve / reject)
     */
    public function submitFinalDecision(Request $request, $id)
    {
        $request->validate([
            'decision' => 'required|in:approved,not_approved,approved_with_minor_revisions,approved_with_major_revisions',
            'presentation_type' => 'required|in:powerpoint,poster',
            'comments' => 'required|min:20',
        ]);

        $paper = FullPaper::with(['abstract', 'reviewAssignments.fullPaperReview'])->findOrFail($id);

        // Save decision
        $paper->update([
            'status' => $request->decision === 'not_approved' ? 'REJECTED' : 'APPROVED',
            'final_decision' => $request->decision,
            'presentation_type' => $request->presentation_type,
            'leader_comments' => $request->comments,
            'decision_made_at' => now(),
        ]);

        // Gather reviews
        $reviews = $paper->reviewAssignments->map(fn($a) => $a->fullPaperReview)->filter();

        // Generate PDF
        $pdf = Pdf::loadView('emails.final_decision_pdf', compact('paper', 'reviews'));
        $pdfContent = $pdf->output();

        // Send email to author
        $authorEmail = $paper->abstract->author_email;
        Mail::to($authorEmail)->send(new FinalDecisionMail($paper, $pdfContent));

        // Redirect to full papers review page with success message
        return redirect('/reviewer/fullpapers-review')
            ->with('success', 'Decision submitted and author notified.');
    }

    public function submitReview(Request $request, $assignmentId)
    {
        $assignment = ReviewAssignment::findOrFail($assignmentId);

        // Prevent double submission
        if ($assignment->fullPaperReview) {
            return back()->with('error', 'You have already submitted this review.');
        }

        // Validation
        $request->validate([
            'overall_comments' => 'required|min:50',
            'recommendation' => 'required|in:accept,needs_minor_revisions,needs_major_revisions,reject',
            'paper_suitability' => 'required',
            // Optional: numeric score fields
            'title_appropriate' => 'required|numeric|min:0|max:2',
            'title_reflects_content' => 'required|numeric|min:0|max:3',
            'abstract_word_count' => 'required|numeric|min:0|max:2',
            'abstract_completeness' => 'required|numeric|min:0|max:3',
            'intro_background' => 'required|numeric|min:0|max:3',
            'intro_originality' => 'required|numeric|min:0|max:5',
            'intro_objectives' => 'required|numeric|min:0|max:2',
            'methods_replication' => 'required|numeric|min:0|max:10',
            'methods_design' => 'required|numeric|min:0|max:5',
            'methods_statistics' => 'required|numeric|min:0|max:5',
            'methods_ethics' => 'required|numeric|min:0|max:5',
            'results_insights' => 'required|numeric|min:0|max:5',
            'results_narrative' => 'required|numeric|min:0|max:5',
            'results_data_clarity' => 'required|numeric|min:0|max:8',
            'results_visuals' => 'required|numeric|min:0|max:5',
            'results_referencing' => 'required|numeric|min:0|max:2',
            'discussion_context' => 'required|numeric|min:0|max:2',
            'discussion_objectives' => 'required|numeric|min:0|max:2',
            'discussion_significance' => 'required|numeric|min:0|max:5',
            'discussion_theme' => 'required|numeric|min:0|max:2',
            'discussion_references' => 'required|numeric|min:0|max:4',
            'conclusion_objectives' => 'required|numeric|min:0|max:2',
            'conclusion_consistency' => 'required|numeric|min:0|max:5',
            'conclusion_contribution' => 'required|numeric|min:0|max:3',
            'acknowledgement_present' => 'required|numeric|min:0|max:1',
            'references_accuracy' => 'required|numeric|min:0|max:1',
            'references_balance' => 'required|numeric|min:0|max:1',
            'references_citation' => 'required|numeric|min:0|max:1',
            'references_matching' => 'required|numeric|min:0|max:1',
        ]);

        // Calculate scores
        $scoreTitle = $request->title_appropriate + $request->title_reflects_content;
        $scoreAbstract = $request->abstract_word_count + $request->abstract_completeness;
        $scoreIntroduction = $request->intro_background + $request->intro_originality + $request->intro_objectives;
        $scoreMethods = $request->methods_replication + $request->methods_design + $request->methods_statistics + $request->methods_ethics;
        $scoreResults = $request->results_insights + $request->results_narrative + $request->results_data_clarity + $request->results_visuals + $request->results_referencing;
        $scoreDiscussion = $request->discussion_context + $request->discussion_objectives + $request->discussion_significance + $request->discussion_theme + $request->discussion_references;
        $scoreConclusion = $request->conclusion_objectives + $request->conclusion_consistency + $request->conclusion_contribution;
        $scoreReferences = $request->acknowledgement_present + $request->references_accuracy + $request->references_balance + $request->references_citation + $request->references_matching;

        $totalScore = $scoreTitle + $scoreAbstract + $scoreIntroduction + $scoreMethods + $scoreResults + $scoreDiscussion + $scoreConclusion + $scoreReferences;

        // Save review
        FullPaperReview::create([

        'review_assignment_id' => $assignment->id,

        /*
        |--------------------------------------------------------------------------
        | SECTION TOTALS
        |--------------------------------------------------------------------------
        */

        'score_title' => $scoreTitle,
        'score_abstract' => $scoreAbstract,
        'score_introduction' => $scoreIntroduction,
        'score_methods' => $scoreMethods,
        'score_results' => $scoreResults,
        'score_discussion' => $scoreDiscussion,
        'score_conclusion' => $scoreConclusion,
        'score_references' => $scoreReferences,

        /*
        |--------------------------------------------------------------------------
        | INDIVIDUAL SCORES
        |--------------------------------------------------------------------------
        */

        'title_appropriate' => $request->title_appropriate,
        'title_reflects_content' => $request->title_reflects_content,

        'abstract_word_count' => $request->abstract_word_count,
        'abstract_completeness' => $request->abstract_completeness,

        'intro_background' => $request->intro_background,
        'intro_originality' => $request->intro_originality,
        'intro_objectives' => $request->intro_objectives,

        'methods_replication' => $request->methods_replication,
        'methods_design' => $request->methods_design,
        'methods_statistics' => $request->methods_statistics,
        'methods_ethics' => $request->methods_ethics,

        'results_insights' => $request->results_insights,
        'results_narrative' => $request->results_narrative,
        'results_data_clarity' => $request->results_data_clarity,
        'results_visuals' => $request->results_visuals,
        'results_referencing' => $request->results_referencing,

        'discussion_context' => $request->discussion_context,
        'discussion_objectives' => $request->discussion_objectives,
        'discussion_significance' => $request->discussion_significance,
        'discussion_theme' => $request->discussion_theme,
        'discussion_references' => $request->discussion_references,

        'conclusion_objectives' => $request->conclusion_objectives,
        'conclusion_consistency' => $request->conclusion_consistency,
        'conclusion_contribution' => $request->conclusion_contribution,

        'acknowledgement_present' => $request->acknowledgement_present,
        'references_accuracy' => $request->references_accuracy,
        'references_balance' => $request->references_balance,
        'references_citation' => $request->references_citation,
        'references_matching' => $request->references_matching,

        /*
        |--------------------------------------------------------------------------
        | COMMENTS
        |--------------------------------------------------------------------------
        */

        'title_comments' => $request->title_comments,
        'abstract_comments' => $request->abstract_comments,
        'introduction_comments' => $request->intro_comments,
        'methods_comments' => $request->methods_comments,
        'results_comments' => $request->results_comments,
        'discussion_comments' => $request->discussion_comments,
        'conclusion_comments' => $request->conclusion_comments,
        'references_comments' => $request->references_comments,

        'overall_comments' => $request->overall_comments,

        'recommendation' => $request->recommendation,
        'presentation_type' => $request->paper_suitability,

        'total_score' => $totalScore,
        'submitted_at' => now(),
    ]);

        // Update assignment status
        $assignment->update(['status' => 'completed']);

        return redirect()->route('reviewer.review.success')
        ->with([
            'total_score' => $totalScore,
            'recommendation' => $request->recommendation,
        ]);
    }

    public function showFullPaperReviews($paperId)
    {
        $paper = FullPaper::with('submittedAbstract')->findOrFail($paperId);

        // Get all review assignments for this paper with reviewer and review relation
        $reviews = ReviewAssignment::with(['prequalifiedReviewer', 'peerReviewer', 'fullPaperReview'])
                    ->where('full_paper_id', $paper->id)
                    ->get();

        return view('reviewer.fullpapers-decision', [
            'paper' => $paper,
            'reviews' => $reviews
        ]);
    }

    public function adminCompletedReviews()
{
    $papers = \App\Models\FullPaper::with('reviews', 'abstract', 'abstract.subtheme')
        ->whereIn('status', ['approved', 'rejected'])
        ->get();

    $subthemes = $papers->pluck('sub_theme')->unique();

    return view('admin.fullpapers.completed', compact('papers', 'subthemes'));
}

public function adminAllReviews($id)
{
    $paper = FullPaper::with([
        'abstract.subTheme',
        'reviewAssignments.prequalifiedReviewer',
        'reviewAssignments.peerReviewer',
        'reviewAssignments.fullPaperReview'
    ])->findOrFail($id);

    $reviews = $paper->reviewAssignments;

    return view('admin.fullpapers.all-reviews', compact('paper', 'reviews'));
}
}