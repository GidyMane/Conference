<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FullPaper;
use App\Models\PrequalifiedReviewer;
use App\Models\ReviewAssignment;
use App\Models\User;
use App\Models\FullPaperReview;
use App\Models\SubTheme;
use App\Models\AbstractAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReviewAssignmentMail;
use App\Mail\FinalDecisionMail;

class FullPaperReviewController extends Controller
{
    /**
     * Reviewer dashboard
     * Show only papers in reviewer's assigned subtheme(s)
     */
    public function index()
    {
        $reviewerId = auth()->id();

        $papers = FullPaper::with(['abstract.subTheme'])
            ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId);
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
     * Assign reviewers form
     * Only for papers in reviewer's assigned subtheme
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

        /*
        |--------------------------------------------------------------------------
        | PREQUALIFIED REVIEWERS (MAX 3 ACTIVE)
        |--------------------------------------------------------------------------
        */
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
            ->orderBy('full_name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PEER REVIEWERS (AUTHORS IN SAME SUBTHEME, MAX 3 ACTIVE)
        |--------------------------------------------------------------------------
        */
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
     * Assign reviewers
     */
    public function assignReviewers(Request $request, $paperId)
    {
        $request->validate([
            'reviewer1' => 'required',
            'reviewer2' => 'required|different:reviewer1',
            'reviewer3' => 'required|different:reviewer1|different:reviewer2',
        ]);

        DB::transaction(function () use ($request, $paperId) {
            $paper = FullPaper::with('abstract')->lockForUpdate()->findOrFail($paperId);
            $subThemeId = $paper->abstract->sub_theme_id;

            $existingAssignments = ReviewAssignment::where('full_paper_id', $paper->id)->count();

            if ($existingAssignments >= 3) {
                throw ValidationException::withMessages([
                    'assignment' => 'This paper has already been assigned reviewers.'
                ]);
            }

            $assignments = [];

            /*
            |--------------------------------------------------------------------------
            | PREQUALIFIED REVIEWER CHECK
            |--------------------------------------------------------------------------
            */
            $prequalified = PrequalifiedReviewer::where('id', $request->reviewer1)
                ->where('sub_theme_id', $subThemeId)
                ->first();

            if (!$prequalified) {
                throw ValidationException::withMessages([
                    'reviewer1' => 'Selected prequalified reviewer must belong to this subtheme.'
                ]);
            }

            $prequalifiedActiveCount = ReviewAssignment::where('prequalified_reviewer_id', $request->reviewer1)
                ->whereIn('status', ['pending', 'started'])
                ->lockForUpdate()
                ->count();

            if ($prequalifiedActiveCount >= 3) {
                throw ValidationException::withMessages([
                    'reviewer1' => 'Selected prequalified reviewer is already at capacity.'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | PEER REVIEWER CHECK (MUST BE SAME SUBTHEME)
            |--------------------------------------------------------------------------
            */
            foreach (['reviewer2', 'reviewer3'] as $field) {
                $peerId = $request->$field;

                $peer = User::where('id', $peerId)
                    ->where('role', 'AUTHOR')
                    ->whereHas('submittedAbstracts', function ($q) use ($subThemeId) {
                        $q->where('sub_theme_id', $subThemeId)
                          ->whereHas('fullPaper');
                    })
                    ->first();

                if (!$peer) {
                    throw ValidationException::withMessages([
                        $field => 'Selected peer reviewer must belong to this subtheme.'
                    ]);
                }

                $peerActiveCount = ReviewAssignment::where('peer_reviewer_id', $peerId)
                    ->whereIn('status', ['pending', 'started'])
                    ->lockForUpdate()
                    ->count();

                if ($peerActiveCount >= 3) {
                    throw ValidationException::withMessages([
                        $field => 'Selected peer reviewer is already at capacity.'
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CREATE ASSIGNMENTS
            |--------------------------------------------------------------------------
            */
            $assignments[] = ReviewAssignment::create([
                'full_paper_id'             => $paper->id,
                'prequalified_reviewer_id'  => $request->reviewer1,
                'review_token'              => Str::uuid(),
                'status'                    => 'pending',
            ]);

            foreach (['reviewer2', 'reviewer3'] as $field) {
                $assignments[] = ReviewAssignment::create([
                    'full_paper_id'    => $paper->id,
                    'peer_reviewer_id' => $request->$field,
                    'review_token'     => Str::uuid(),
                    'status'           => 'pending',
                ]);
            }

            $paper->update([
                'status' => 'UNDER_REVIEW',
            ]);

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
     * Completed reviews
     * Only show completed papers in reviewer's assigned subtheme(s)
     */
    public function completedReviews()
    {
        $reviewerId = auth()->id();

        $subThemeIds = AbstractAssignment::where('reviewer_id', $reviewerId)
            ->pluck('sub_theme_id')
            ->unique();

        $papers = FullPaper::with([
                'reviewAssignments.fullPaperReview',
                'abstract',
                'abstract.subTheme'
            ])
            ->whereIn('status', ['APPROVED', 'REJECTED'])
            ->whereHas('abstract', function ($q) use ($subThemeIds) {
                $q->whereIn('sub_theme_id', $subThemeIds);
            })
            ->latest()
            ->get();

        $subthemes = $papers->pluck('abstract.subTheme')->unique('id');

        return view('reviewer.fullpapers-completed', compact('papers', 'subthemes'));
    }

    /**
     * Show all reviews for one paper
     * Restrict to reviewer's assigned subtheme(s)
     */
    public function allReviews($id)
    {
        $reviewerId = auth()->id();

        $subThemeIds = AbstractAssignment::where('reviewer_id', $reviewerId)
            ->pluck('sub_theme_id')
            ->unique();

        $paper = FullPaper::with([
                'abstract.subTheme',
                'reviewAssignments.prequalifiedReviewer',
                'reviewAssignments.peerReviewer',
                'reviewAssignments.fullPaperReview'
            ])
            ->whereHas('abstract', function ($q) use ($subThemeIds) {
                $q->whereIn('sub_theme_id', $subThemeIds);
            })
            ->findOrFail($id);

        $reviews = $paper->reviewAssignments;

        return view('reviewer.fullpapers-decision', compact('paper', 'reviews'));
    }

    /**
     * Submit final decision
     */
    public function submitFinalDecision(Request $request, $id)
    {
        $request->validate([
            'decision'          => 'required|in:approved,not_approved,approved_with_minor_revisions,approved_with_major_revisions',
            'presentation_type' => 'required|in:powerpoint,poster',
            'comments'          => 'required|min:20',
        ]);

        $paper = FullPaper::with(['abstract', 'reviewAssignments.fullPaperReview'])->findOrFail($id);

        $paper->update([
            'status'            => $request->decision === 'not_approved' ? 'REJECTED' : 'APPROVED',
            'final_decision'    => $request->decision,
            'presentation_type' => $request->presentation_type,
            'leader_comments'   => $request->comments,
            'decision_made_at'  => now(),
        ]);

        $reviews = $paper->reviewAssignments->map(fn ($a) => $a->fullPaperReview)->filter();

        $pdf = Pdf::loadView('emails.final_decision_pdf', compact('paper', 'reviews'));
        $pdfContent = $pdf->output();

        Mail::to($paper->abstract->author_email)->send(new FinalDecisionMail($paper, $pdfContent));

        return redirect('/reviewer/fullpapers-review')
            ->with('success', 'Decision submitted and author notified.');
    }

    /**
     * Submit review
     */
    public function submitReview(Request $request, $assignmentId)
    {
        $assignment = ReviewAssignment::findOrFail($assignmentId);

        if ($assignment->fullPaperReview) {
            return back()->with('error', 'You have already submitted this review.');
        }

        $request->validate([
            'overall_comments' => 'required|min:50',
            'recommendation' => 'required|in:accept,needs_minor_revisions,needs_major_revisions,reject',
            'paper_suitability' => 'required',

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

        $scoreTitle = $request->title_appropriate + $request->title_reflects_content;
        $scoreAbstract = $request->abstract_word_count + $request->abstract_completeness;
        $scoreIntroduction = $request->intro_background + $request->intro_originality + $request->intro_objectives;
        $scoreMethods = $request->methods_replication + $request->methods_design + $request->methods_statistics + $request->methods_ethics;
        $scoreResults = $request->results_insights + $request->results_narrative + $request->results_data_clarity + $request->results_visuals + $request->results_referencing;
        $scoreDiscussion = $request->discussion_context + $request->discussion_objectives + $request->discussion_significance + $request->discussion_theme + $request->discussion_references;
        $scoreConclusion = $request->conclusion_objectives + $request->conclusion_consistency + $request->conclusion_contribution;
        $scoreReferences = $request->acknowledgement_present + $request->references_accuracy + $request->references_balance + $request->references_citation + $request->references_matching;

        $totalScore = $scoreTitle + $scoreAbstract + $scoreIntroduction + $scoreMethods + $scoreResults + $scoreDiscussion + $scoreConclusion + $scoreReferences;

        FullPaperReview::create([
            'review_assignment_id' => $assignment->id,

            'score_title' => $scoreTitle,
            'score_abstract' => $scoreAbstract,
            'score_introduction' => $scoreIntroduction,
            'score_methods' => $scoreMethods,
            'score_results' => $scoreResults,
            'score_discussion' => $scoreDiscussion,
            'score_conclusion' => $scoreConclusion,
            'score_references' => $scoreReferences,

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

        $assignment->update(['status' => 'completed']);

        return redirect()->route('reviewer.review.success')->with([
            'total_score' => $totalScore,
            'recommendation' => $request->recommendation,
        ]);
    }

    /**
     * Admin completed reviews
     */
    public function adminCompletedReviews(Request $request)
    {
        $query = FullPaper::with(['reviewAssignments.fullPaperReview', 'abstract', 'abstract.subTheme'])
            ->whereIn('status', ['APPROVED', 'REJECTED']);

        if ($request->filled('subtheme')) {
            $query->whereHas('abstract', function ($q) use ($request) {
                $q->where('sub_theme_id', $request->subtheme);
            });
        }

        $papers = $query->latest()->get();
        $subthemes = SubTheme::all();

        return view('admin.fullpapers.completed', compact('papers', 'subthemes'));
    }

    /**
     * Admin all reviews
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
}