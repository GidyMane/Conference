<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FullPaper;
use App\Models\PrequalifiedReviewer;
use App\Models\ReviewAssignment;
use App\Models\User;
use App\Models\Reviewer;
use App\Models\SubTheme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ReviewAssignmentMail;
use App\Models\FullPaperReview;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FinalDecisionMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeaderFullPapersExport;

class FullPaperReviewController extends Controller
{
    /**
     * Dashboard
     */
    public function index()
    {
        $reviewerId = auth()->id();

        $reviewer = Reviewer::where('user_id', $reviewerId)->first();

        if (!$reviewer) {
            abort(403, 'You are not registered as a reviewer.');
        }

        $reviewerSubThemeIds = DB::table('reviewer_sub_theme')
            ->where('reviewer_id', $reviewer->id)
            ->pluck('sub_theme_id');

        $papers = FullPaper::with([
                'abstract.subTheme',
                'reviewAssignments.fullPaperReview'
            ])
            ->whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
            })
            ->latest()
            ->get();

        $stats = [
            'pending_assignment' => $papers->where('status', 'PENDING')->count(),
            'under_review'       => $papers->where('status', 'UNDER_REVIEW')->count(),
            'total'              => $papers->count(),
            'completed'          => $papers->whereIn('status', ['APPROVED', 'REJECTED'])->count(),
        ];

        return view('reviewer.fullpapers-review', compact('papers', 'stats'));
    }

    /**
     * Show assign form for a paper
     */
    public function showAssignForm($id)
    {
        $reviewerId = auth()->id();

        $paper = FullPaper::with(['abstract.subTheme'])
            ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId);
            })
            ->findOrFail($id);

        $subThemeId = $paper->abstract->sub_theme_id ?? null;

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
            'id'       => $reviewId,
            'reviewer' => (object)['name' => 'Dr Alice'],
            'comments' => 'Excellent contribution to the field.',
            'score'    => 90,
        ];

        $sectionScores = [
            'Introduction'      => 9,
            'Literature Review' => 8,
            'Methodology'       => 9,
            'Results'           => 9,
            'Conclusion'        => 8,
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
                'id'                     => 1,
                'user'                   => (object)['name' => 'Dr Alice'],
                'is_active'              => true,
                'current_assigned_count' => 2,
            ],
            (object)[
                'id'                     => 2,
                'user'                   => (object)['name' => 'Prof Bob'],
                'is_active'              => true,
                'current_assigned_count' => 1,
            ],
            (object)[
                'id'                     => 3,
                'user'                   => (object)['name' => 'Dr Carol'],
                'is_active'              => false,
                'current_assigned_count' => 0,
            ],
        ]);

        $stats = [
            'total'       => 3,
            'active'      => 2,
            'available'   => 2,
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
                'name'           => 'Dr Alice',
                'total_assigned' => 3,
                'pending'        => 1,
                'completed'      => 2,
            ],
            (object)[
                'name'           => 'Prof Bob',
                'total_assigned' => 2,
                'pending'        => 0,
                'completed'      => 2,
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
            'id'       => $paperId,
            'title'    => 'AI in Agriculture',
            'reviews'  => [],
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
            'id'          => $id,
            'title'       => 'AI in Agriculture',
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

    /**
     * Assign reviewers to a paper
     */
    public function assignReviewers(Request $request, $paperId)
    {
        $request->validate([
            'reviewer1' => 'required',
            'reviewer2' => 'required|different:reviewer1',
            'reviewer3' => 'required|different:reviewer1|different:reviewer2',
        ]);

        DB::transaction(function () use ($request, $paperId) {

            $paper = FullPaper::lockForUpdate()->findOrFail($paperId);

            $existingAssignments = ReviewAssignment::where('full_paper_id', $paper->id)->count();

            if ($existingAssignments >= 3) {
                throw ValidationException::withMessages([
                    'assignment' => 'This paper has already been assigned reviewers.'
                ]);
            }

            $assignments = [];

            $prequalifiedActiveCount = ReviewAssignment::where('prequalified_reviewer_id', $request->reviewer1)
                ->whereIn('status', ['pending', 'started'])
                ->lockForUpdate()
                ->count();

            if ($prequalifiedActiveCount >= 3) {
                throw ValidationException::withMessages([
                    'reviewer1' => 'Selected prequalified reviewer is already at capacity.'
                ]);
            }

            foreach (['reviewer2', 'reviewer3'] as $field) {
                $peerActiveCount = ReviewAssignment::where('peer_reviewer_id', $request->$field)
                    ->whereIn('status', ['pending', 'started'])
                    ->lockForUpdate()
                    ->count();

                if ($peerActiveCount >= 3) {
                    throw ValidationException::withMessages([
                        $field => 'Selected peer reviewer is already at capacity.'
                    ]);
                }
            }

            $assignments[] = ReviewAssignment::create([
                'full_paper_id'            => $paper->id,
                'prequalified_reviewer_id' => $request->reviewer1,
                'review_token'             => Str::uuid(),
                'status'                   => 'pending'
            ]);

            foreach (['reviewer2', 'reviewer3'] as $field) {
                $assignments[] = ReviewAssignment::create([
                    'full_paper_id'    => $paper->id,
                    'peer_reviewer_id' => $request->$field,
                    'review_token'     => Str::uuid(),
                    'status'           => 'pending'
                ]);
            }

            $paper->update(['status' => 'under_review']);

            foreach ($assignments as $assignment) {
                $email = $assignment->prequalified_reviewer_id
                    ? $assignment->prequalifiedReviewer->email
                    : $assignment->peerReviewer->email;

                Mail::to($email)->send(new ReviewAssignmentMail($assignment));
            }
        });

        return redirect()
            ->route('reviewer.fullpapers.index')
            ->with('success', 'Reviewers assigned and emails sent.');
    }

    /**
     * List all papers that have completed all 3 reviews — awaiting leader decision
     *
     * FIX: Changed paginate(15) to get() so the blade can use
     * collection methods like ->where() and ->count() for stats,
     * and all papers are returned (not just the first 15).
     * Also added 'awaiting' to the status filter so those papers appear too.
     */
    public function completedReviews()
    {
        $reviewerId = auth()->id();

        $reviewer = Reviewer::where('user_id', $reviewerId)->first();

        if (!$reviewer) {
            abort(403, 'You are not registered as a reviewer.');
        }

        $reviewerSubThemeIds = DB::table('reviewer_sub_theme')
            ->where('reviewer_id', $reviewer->id)
            ->pluck('sub_theme_id');

        $allowedStatuses = ['awaiting', 'APPROVED', 'REJECTED', 'NOT_APPROVED'];

        // Stats come from dedicated DB queries so they always reflect the full
        // dataset — not just the current page returned by paginate().
        $stats = [
            'total' => FullPaper::whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                            $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
                        })->whereIn('status', $allowedStatuses)->count(),

            'awaiting' => FullPaper::whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                            $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
                        })->where('status', 'awaiting')->count(),

            'approved' => FullPaper::whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                            $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
                        })->whereIn('status', ['APPROVED', 'approved'])->count(),

            'rejected' => FullPaper::whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                            $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
                        })->whereIn('status', ['REJECTED', 'rejected', 'NOT_APPROVED', 'not_approved'])->count(),
        ];

        // Paginated papers — stats are independent so tiles always show correct totals.
        $papers = FullPaper::with(['reviews', 'abstract', 'abstract.subTheme'])
            ->whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
            })
            ->whereIn('status', $allowedStatuses)
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        $subthemes = SubTheme::whereIn('id', $reviewerSubThemeIds)
            ->orderBy('full_name')
            ->get();

        return view('reviewer.fullpapers-completed', compact('papers', 'stats', 'subthemes'));
    }

    /**
     * Show all 3 reviews for a specific paper + decision form
     */
    public function allReviews($id)
    {
        $reviewerId = auth()->id();

        $reviewer = Reviewer::where('user_id', $reviewerId)->first();

        if (!$reviewer) {
            abort(403, 'You are not registered as a reviewer.');
        }

        $reviewerSubThemeIds = DB::table('reviewer_sub_theme')
            ->where('reviewer_id', $reviewer->id)
            ->pluck('sub_theme_id');

        $paper = FullPaper::with([
            'abstract.subTheme',
            'reviewAssignments.prequalifiedReviewer',
            'reviewAssignments.peerReviewer',
            'reviewAssignments.fullPaperReview'
        ])
        ->whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
            $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
        })
        ->findOrFail($id);

        $reviews = $paper->reviewAssignments;

        return view('reviewer.fullpapers-decision', compact('paper', 'reviews'));
    }

    /**
     * Sub-theme leader submits final decision
     */
    public function submitFinalDecision(Request $request, $id)
    {
        $request->validate([
            'decision' => 'required|in:approved,not_approved,approved_with_minor_revisions,approved_with_major_revisions',
            'comments' => 'required|min:20',
        ]);

        $paper = FullPaper::with(['abstract', 'reviewAssignments.fullPaperReview'])->findOrFail($id);

        $paper->update([
            'status'            => $request->decision === 'not_approved' ? 'REJECTED' : 'APPROVED',
            'final_decision'    => $request->decision,
            'presentation_type' => $request->presentation_type ?? null,
            'leader_comments'   => $request->comments,
            'decision_made_at'  => now(),
        ]);

        $reviews = $paper->reviewAssignments->map(fn($a) => $a->fullPaperReview)->filter();

        $pdf        = Pdf::loadView('emails.final_decision_pdf', compact('paper', 'reviews'));
        $pdfContent = $pdf->output();

        $authorEmail = $paper->abstract->author_email;
        Mail::to($authorEmail)->send(new FinalDecisionMail($paper, $pdfContent));

        return redirect('/reviewer/fullpapers-review')
            ->with('success', 'Decision submitted and author notified.');
    }

    /**
     * Submit a review for an assignment
     */
    public function submitReview(Request $request, $assignmentId)
    {
        $assignment = ReviewAssignment::findOrFail($assignmentId);

        if ($assignment->fullPaperReview) {
            return back()->with('error', 'You have already submitted this review.');
        }

        $request->validate([
            'overall_comments'        => 'required|min:50',
            'recommendation'          => 'required|in:accept,needs_minor_revisions,needs_major_revisions,reject',
            'title_appropriate'       => 'required|numeric|min:0|max:2',
            'title_reflects_content'  => 'required|numeric|min:0|max:3',
            'abstract_word_count'     => 'required|numeric|min:0|max:2',
            'abstract_completeness'   => 'required|numeric|min:0|max:3',
            'intro_background'        => 'required|numeric|min:0|max:3',
            'intro_originality'       => 'required|numeric|min:0|max:5',
            'intro_objectives'        => 'required|numeric|min:0|max:2',
            'methods_replication'     => 'required|numeric|min:0|max:10',
            'methods_design'          => 'required|numeric|min:0|max:5',
            'methods_statistics'      => 'required|numeric|min:0|max:5',
            'methods_ethics'          => 'required|numeric|min:0|max:5',
            'results_insights'        => 'required|numeric|min:0|max:5',
            'results_narrative'       => 'required|numeric|min:0|max:5',
            'results_data_clarity'    => 'required|numeric|min:0|max:8',
            'results_visuals'         => 'required|numeric|min:0|max:5',
            'results_referencing'     => 'required|numeric|min:0|max:2',
            'discussion_context'      => 'required|numeric|min:0|max:2',
            'discussion_objectives'   => 'required|numeric|min:0|max:2',
            'discussion_significance' => 'required|numeric|min:0|max:5',
            'discussion_theme'        => 'required|numeric|min:0|max:2',
            'discussion_references'   => 'required|numeric|min:0|max:4',
            'conclusion_objectives'   => 'required|numeric|min:0|max:2',
            'conclusion_consistency'  => 'required|numeric|min:0|max:5',
            'conclusion_contribution' => 'required|numeric|min:0|max:3',
            'acknowledgement_present' => 'required|numeric|min:0|max:1',
            'references_accuracy'     => 'required|numeric|min:0|max:1',
            'references_balance'      => 'required|numeric|min:0|max:1',
            'references_citation'     => 'required|numeric|min:0|max:1',
            'references_matching'     => 'required|numeric|min:0|max:1',
        ]);

        $scoreTitle        = $request->title_appropriate + $request->title_reflects_content;
        $scoreAbstract     = $request->abstract_word_count + $request->abstract_completeness;
        $scoreIntroduction = $request->intro_background + $request->intro_originality + $request->intro_objectives;
        $scoreMethods      = $request->methods_replication + $request->methods_design + $request->methods_statistics + $request->methods_ethics;
        $scoreResults      = $request->results_insights + $request->results_narrative + $request->results_data_clarity + $request->results_visuals + $request->results_referencing;
        $scoreDiscussion   = $request->discussion_context + $request->discussion_objectives + $request->discussion_significance + $request->discussion_theme + $request->discussion_references;
        $scoreConclusion   = $request->conclusion_objectives + $request->conclusion_consistency + $request->conclusion_contribution;
        $scoreReferences   = $request->acknowledgement_present + $request->references_accuracy + $request->references_balance + $request->references_citation + $request->references_matching;

        $totalScore = $scoreTitle + $scoreAbstract + $scoreIntroduction + $scoreMethods + $scoreResults + $scoreDiscussion + $scoreConclusion + $scoreReferences;

        FullPaperReview::create([
            'review_assignment_id'    => $assignment->id,

            'score_title'             => $scoreTitle,
            'score_abstract'          => $scoreAbstract,
            'score_introduction'      => $scoreIntroduction,
            'score_methods'           => $scoreMethods,
            'score_results'           => $scoreResults,
            'score_discussion'        => $scoreDiscussion,
            'score_conclusion'        => $scoreConclusion,
            'score_references'        => $scoreReferences,

            'title_appropriate'       => $request->title_appropriate,
            'title_reflects_content'  => $request->title_reflects_content,

            'abstract_word_count'     => $request->abstract_word_count,
            'abstract_completeness'   => $request->abstract_completeness,

            'intro_background'        => $request->intro_background,
            'intro_originality'       => $request->intro_originality,
            'intro_objectives'        => $request->intro_objectives,

            'methods_replication'     => $request->methods_replication,
            'methods_design'          => $request->methods_design,
            'methods_statistics'      => $request->methods_statistics,
            'methods_ethics'          => $request->methods_ethics,

            'results_insights'        => $request->results_insights,
            'results_narrative'       => $request->results_narrative,
            'results_data_clarity'    => $request->results_data_clarity,
            'results_visuals'         => $request->results_visuals,
            'results_referencing'     => $request->results_referencing,

            'discussion_context'      => $request->discussion_context,
            'discussion_objectives'   => $request->discussion_objectives,
            'discussion_significance' => $request->discussion_significance,
            'discussion_theme'        => $request->discussion_theme,
            'discussion_references'   => $request->discussion_references,

            'conclusion_objectives'   => $request->conclusion_objectives,
            'conclusion_consistency'  => $request->conclusion_consistency,
            'conclusion_contribution' => $request->conclusion_contribution,

            'acknowledgement_present' => $request->acknowledgement_present,
            'references_accuracy'     => $request->references_accuracy,
            'references_balance'      => $request->references_balance,
            'references_citation'     => $request->references_citation,
            'references_matching'     => $request->references_matching,

            'title_comments'          => $request->title_comments,
            'abstract_comments'       => $request->abstract_comments,
            'introduction_comments'   => $request->intro_comments,
            'methods_comments'        => $request->methods_comments,
            'results_comments'        => $request->results_comments,
            'discussion_comments'     => $request->discussion_comments,
            'conclusion_comments'     => $request->conclusion_comments,
            'references_comments'     => $request->references_comments,

            'overall_comments'        => $request->overall_comments,
            'recommendation'          => $request->recommendation,
            'presentation_type'       => $request->paper_suitability ?? null,

            'total_score'             => $totalScore,
            'submitted_at'            => now(),
        ]);

        $assignment->update(['status' => 'completed']);

        return redirect()->route('reviewer.review.success')
            ->with([
                'total_score'    => $totalScore,
                'recommendation' => $request->recommendation,
            ]);
    }

    /**
     * Show full paper reviews for a specific paper (reviewer view)
     */
    public function showFullPaperReviews($paperId)
    {
        $reviewerId = auth()->id();

        $reviewer = Reviewer::where('user_id', $reviewerId)->first();

        if (!$reviewer) {
            abort(403, 'You are not registered as a reviewer.');
        }

        $reviewerSubThemeIds = DB::table('reviewer_sub_theme')
            ->where('reviewer_id', $reviewer->id)
            ->pluck('sub_theme_id');

        $paper = FullPaper::with('abstract.subTheme')
            ->whereHas('abstract', function ($q) use ($reviewerSubThemeIds) {
                $q->whereIn('sub_theme_id', $reviewerSubThemeIds);
            })
            ->findOrFail($paperId);

        $reviews = ReviewAssignment::with([
                'prequalifiedReviewer',
                'peerReviewer',
                'fullPaperReview'
            ])
            ->where('full_paper_id', $paper->id)
            ->get();

        return view('reviewer.fullpapers-decision', compact('paper', 'reviews'));
    }

    /**
     * Admin — list all fully reviewed / decided papers with pagination
     */
    public function adminCompletedReviews()
    {
        $stats = [
            'total'    => FullPaper::whereIn('status', [
                                'approved', 'APPROVED',
                                'rejected', 'REJECTED',
                                'not_approved', 'NOT_APPROVED',
                            ])->count(),
            'awaiting' => FullPaper::where('status', 'awaiting')->count(),
            'approved' => FullPaper::whereIn('status', ['approved', 'APPROVED'])->count(),
            'rejected' => FullPaper::whereIn('status', [
                                'rejected', 'REJECTED',
                                'not_approved', 'NOT_APPROVED',
                            ])->count(),
        ];

        $papers = FullPaper::with([
                'reviews',
                'abstract',
                'abstract.subtheme',
            ])
            ->whereIn('status', [
                'approved', 'APPROVED',
                'rejected', 'REJECTED',
                'not_approved', 'NOT_APPROVED',
            ])
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        $subthemes = SubTheme::orderBy('full_name')->get();

        return view('admin.fullpapers.completed', compact('papers', 'stats', 'subthemes'));
    }

    /**
     * Admin — show all reviews for a specific paper
     */
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

    /**
     * Export full papers for the sub-theme leader
     */
    public function export(Request $request)
    {
        $reviewerId = auth()->id();

        $reviewer = Reviewer::where('user_id', $reviewerId)->firstOrFail();

        $subThemeIds = DB::table('reviewer_sub_theme')
            ->where('reviewer_id', $reviewer->id)
            ->pluck('sub_theme_id');

        $status = $request->status ?? null;

        return Excel::download(
            new LeaderFullPapersExport($subThemeIds, $status),
            'subtheme-full-papers.xlsx'
        );
    }

    /**
     * Resend final decision email to author
     */
    public function resendFinalDecisionEmail($id)
    {
        $paper = FullPaper::with([
            'abstract',
            'reviewAssignments.fullPaperReview'
        ])->findOrFail($id);

        if (!$paper->final_decision) {
            return back()->with('error', 'Final decision has not been made yet.');
        }

        $reviews = $paper->reviewAssignments
            ->map(fn($a) => $a->fullPaperReview)
            ->filter();

        $pdf = Pdf::loadView('emails.final_decision_pdf', compact('paper', 'reviews'));

        $pdfContent = $pdf->output();

        Mail::to($paper->abstract->author_email)
            ->send(new FinalDecisionMail($paper, $pdfContent));

        return back()->with(
            'success',
            'Final decision email resent successfully.'
        );
    }

    /**
     * Admin reset final decision
     */
    public function resetFinalDecision($id)
    {
        $paper = FullPaper::findOrFail($id);

        $paper->update([
            'status' => 'UNDER_REVIEW',
            'final_decision' => null,
            'presentation_type' => null,
            'leader_comments' => null,
            'decision_made_at' => null,
        ]);

        return back()->with(
            'success',
            'Final decision has been reset successfully.'
        );
    }
}