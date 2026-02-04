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

        // Base query: abstracts assigned to this reviewer
        $query = SubmittedAbstract::with([
            'subtheme',
            'assignments' => fn($q) => $q->where('reviewer_id', $userId),
            'latestReview'
        ])->whereHas('assignments', fn($q) => $q->where('reviewer_id', $userId));

        // --- Filters ---
        $statusMap = [
            'pending'  => 'UNDER_REVIEW',
            'reviewed' => ['APPROVED', 'REJECTED'], // multiple statuses
            'approved' => 'APPROVED',
            'rejected' => 'REJECTED',
        ];

        if ($request->filled('status') && isset($statusMap[$request->status])) {
            $dbStatus = $statusMap[$request->status];

            if (is_array($dbStatus)) {
                $query->whereIn('status', $dbStatus);
            } else {
                $query->where('status', $dbStatus);
            }
        }

        // Date range filter
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

        // --- Sorting ---
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

        // Get filtered & sorted abstracts
        $abstracts = $query->get();

        // --- Status counts ---
        $statusCounts = [
            'pending'  => $abstracts->where('status', 'UNDER_REVIEW')->count(),
            'approved' => $abstracts->where('status', 'APPROVED')->count(),
            'reviewed' => $abstracts->whereIn('status', ['APPROVED', 'REJECTED'])->count(),
            'rejected' => $abstracts->where('status', 'REJECTED')->count(),
            'total'    => $abstracts->count(),
        ];

        // Upcoming deadlines within 3 days
        $upcomingDeadlines = $abstracts->filter(fn($a) => 
            $a->review_deadline && now()->diffInDays($a->review_deadline, false) <= 3 &&
            now()->diffInDays($a->review_deadline, false) >= 0
        )->count();

        // Reviewer stats placeholders (replace with real calculations)
        $reviewerStats = [
            'avgRating'      => 'N/A',
            'monthlyReviews' => 0,
            'avgReviewTime'  => 'N/A',
            'totalReviews'   => 0,
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
