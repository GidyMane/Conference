<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\SubmittedAbstract;
use App\Models\AbstractReview;
use App\Models\SubTheme;
use App\Models\User;
use App\Models\Reviewer;

class ReviewsController extends Controller
{
    /**
     * Show pending reviews
     */
    public function pendingReviews(Request $request)
    {
        $user = auth()->user(); // logged-in reviewer

        // Base query: abstracts assigned to this reviewer
        $pendingReviews = DB::table('abstract_assignments')
            ->join('submitted_abstracts', 'submitted_abstracts.id', '=', 'abstract_assignments.abstract_id')
            ->leftJoin('sub_themes', 'sub_themes.id', '=', 'submitted_abstracts.sub_theme_id')
            ->leftJoin('abstract_reviews', function ($join) {
                $join->on('abstract_reviews.abstract_id', '=', 'submitted_abstracts.id')
                    ->whereRaw('abstract_reviews.id = (
                        SELECT MAX(id) FROM abstract_reviews AS ar 
                        WHERE ar.abstract_id = submitted_abstracts.id
                    )');
            })
            ->select(
                'abstract_assignments.id as assignment_id',
                'abstract_assignments.assigned_at',
                'submitted_abstracts.id as abstract_id',
                'submitted_abstracts.submission_code',
                'submitted_abstracts.paper_title',
                'submitted_abstracts.author_name',
                'submitted_abstracts.author_email',
                'submitted_abstracts.author_phone',
                'submitted_abstracts.organisation',
                'submitted_abstracts.abstract_text',
                'submitted_abstracts.keywords',
                'submitted_abstracts.status as abstract_status',
                'sub_themes.full_name as subtheme_name',
                'abstract_reviews.comment as review_comment',
                'abstract_reviews.decision as review_decision',
                'abstract_reviews.created_at as review_created_at',
                'abstract_reviews.reviewer_id as review_reviewer_id'
            )
            ->where('abstract_assignments.reviewer_id', $user->id);

        // Optional filters
        if ($request->filled('date_from')) {
            $pendingReviews->whereDate('abstract_assignments.assigned_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $pendingReviews->whereDate('abstract_assignments.assigned_at', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $pendingReviews->where('submitted_abstracts.status', $request->status);
        } else {
            // Default to UNDER_REVIEW only
            $pendingReviews->where('submitted_abstracts.status', 'UNDER_REVIEW');
        }

        $pendingReviews = $pendingReviews
            ->orderBy('abstract_assignments.assigned_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Stats: count by status
        $stats = [
            'pending' => DB::table('abstract_assignments')
                ->join('submitted_abstracts', 'submitted_abstracts.id', '=', 'abstract_assignments.abstract_id')
                ->where('abstract_assignments.reviewer_id', $user->id)
                ->where('submitted_abstracts.status', 'PENDING')
                ->count(),

            'under_review' => DB::table('abstract_assignments')
                ->join('submitted_abstracts', 'submitted_abstracts.id', '=', 'abstract_assignments.abstract_id')
                ->where('abstract_assignments.reviewer_id', $user->id)
                ->where('submitted_abstracts.status', 'UNDER_REVIEW')
                ->count(),
        ];

        return view('reviewer.pending-reviews', compact('pendingReviews', 'stats'));
    }



    /**
     * Show completed reviews
     */
    public function completedReviews(Request $request)
    {
        $user = auth()->user();

        $completedReviews = AbstractReview::with([
                'abstract.subTheme'
            ])
            ->where('reviewer_id', $user->id)
            ->whereIn('decision', ['APPROVED', 'REJECTED'])
            ->whereHas('abstract', function ($q) {
                $q->whereIn('status', ['APPROVED', 'REJECTED']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Stats
        $stats = [
            'approved' => AbstractReview::where('reviewer_id', $user->id)
                ->where('decision', 'APPROVED')
                ->count(),

            'rejected' => AbstractReview::where('reviewer_id', $user->id)
                ->where('decision', 'REJECTED')
                ->count(),

            'needs_revision' => AbstractReview::where('reviewer_id', $user->id)
                ->where('decision', 'NEEDS_REVISION')
                ->count(),
        ];

        return view('reviewer.completed-reviews', compact('completedReviews', 'stats'));
    }

    /**
     * Dummy submit review
     */
    public function submitReview(Request $request)
    {
        $request->validate([
            'abstract_id' => 'required|exists:submitted_abstracts,id',
            'decision' => 'required|in:APPROVED,REJECTED',
            'comment' => 'nullable|string'
        ]);

        AbstractReview::create([
            'abstract_id' => $request->abstract_id,
            'reviewer_id' => auth()->id(),
            'decision' => $request->decision,
            'comment' => $request->comment,
        ]);

        SubmittedAbstract::where('id', $request->abstract_id)
            ->update(['status' => 'REVIEWED']);

        return response()->json([
            'status' => 'success',
            'message' => 'Review submitted successfully'
        ]);
    }

    /**
     * Dummy start review (AJAX)
     */
    public function startReview($assignmentId)
    {
        return response()->json([
            'success' => true,
            'message' => "Dummy review for assignment ID {$assignmentId} started",
        ]);
    }
}
