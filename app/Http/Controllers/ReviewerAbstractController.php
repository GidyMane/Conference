<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use App\Models\Reviewer;
use App\Models\Subtheme;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class ReviewerAbstractController extends Controller
{
    /**
     * Display a listing of the abstracts assigned to the logged-in reviewer.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Base query: only abstracts assigned to this reviewer
        $query = SubmittedAbstract::with([
            'subtheme',
            'assignments' => function ($q) use ($userId) {
                $q->where('reviewer_id', $userId);
            }
        ])->whereHas('assignments', function ($q) use ($userId) {
            $q->where('reviewer_id', $userId);
        });

        // Filters
        if ($request->filled('status')) {
            $query->where('review_status', $request->status);
        }

        if ($request->filled('date_range')) {
            $today = now();
            if ($request->date_range === 'today') {
                $query->whereDate('created_at', $today);
            } elseif ($request->date_range === 'week') {
                $query->whereBetween('created_at', [$today->startOfWeek(), $today->endOfWeek()]);
            } elseif ($request->date_range === 'month') {
                $query->whereMonth('created_at', $today->month);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'newest');

        if ($sort === 'oldest') {
            $query->join('abstract_assignments', 'submitted_abstracts.id', '=', 'abstract_assignments.abstract_id')
                ->where('abstract_assignments.reviewer_id', $userId)
                ->orderBy('abstract_assignments.created_at', 'asc')
                ->select('submitted_abstracts.*');
        } elseif ($sort === 'deadline') {
            $query->orderBy('review_deadline', 'asc');
        } else { // newest
            $query->join('abstract_assignments', 'submitted_abstracts.id', '=', 'abstract_assignments.abstract_id')
                ->where('abstract_assignments.reviewer_id', $userId)
                ->orderBy('abstract_assignments.created_at', 'desc')
                ->select('submitted_abstracts.*');
        }

        $abstracts = $query->get();

        // Status counts
        $statusCounts = [
            'pending' => $abstracts->where('review_status', 'pending')->count(),
            'under_review' => $abstracts->where('review_status', 'under_review')->count(),
            'reviewed' => $abstracts->where('review_status', 'reviewed')->count(),
            'total' => $abstracts->count(),
        ];

        // Upcoming deadlines
        $upcomingDeadlines = $abstracts->filter(function ($a) {
            return $a->review_deadline && now()->diffInDays($a->review_deadline, false) <= 3 && now()->diffInDays($a->review_deadline, false) >= 0;
        })->count();

        // Reviewer stats (example placeholders, replace with real calculations)
        $reviewerStats = [
            'avgRating' => 'N/A',
            'monthlyReviews' => 0,
            'avgReviewTime' => 'N/A',
            'totalReviews' => 0,
        ];

        return view('reviewer.abstracts.index', compact(
            'abstracts', 'statusCounts', 'upcomingDeadlines', 'reviewerStats'
        ));
    }

    /**
     * Show a single abstract.
     */
    public function show($id)
    {
        $abstract = SubmittedAbstract::with(['subtheme', 'assignments.reviewer'])->findOrFail($id);
        return view('reviewer.abstracts.show', compact('abstract'));
    }

    /**
     * Download abstract PDF (dummy example).
     */
    public function download($id)
    {
        $abstract = SubmittedAbstract::findOrFail($id);

        $content = "Title: {$abstract->title}\nAuthor: {$abstract->author_name}\nStatus: {$abstract->review_status}";
        $filename = "abstract_{$abstract->submission_id}.txt";

        return Response::make($content, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename={$filename}"
        ]);
    }
}
