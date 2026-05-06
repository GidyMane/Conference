<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\FullPaper;
use App\Models\SubmittedAbstract;
use Illuminate\Support\Facades\DB;

class ReviewerFullpaperController extends Controller
{
    /**
     * Display full papers for abstracts the reviewer approved (dummy data)
     */
    public function index()
    {
        $reviewerId = auth()->id();

        // Fetch full papers linked to abstracts assigned to this reviewer
        $fullPapers = FullPaper::with(['abstract.subTheme'])
            ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId);
            })
            ->latest()
            ->paginate(10); // Pagination, adjust per your needs

        // Total abstracts assigned to this reviewer
        $totalAssigned = SubmittedAbstract::whereHas('assignments', function ($q) use ($reviewerId) {
            $q->where('reviewer_id', $reviewerId);
        })->count();

        // Full papers submitted for assigned abstracts
        $submitted = FullPaper::whereHas('abstract.assignments', function ($q) use ($reviewerId) {
            $q->where('reviewer_id', $reviewerId);
        })->count();

        // Pending = assigned abstracts approved but without a full paper
        $pending = SubmittedAbstract::whereHas('assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId)
                  ->where('status', 'approved'); // only approved abstracts
            })
            ->whereDoesntHave('fullPaper')
            ->count();

        // Approved = full papers that have been approved
        $approved = FullPaper::where('status', 'approved')
            ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId);
            })
            ->count();

        // Stats array to send to the view
        $stats = [
            'total'    => $submitted,
            'pending'  => $pending,
            'approved' => $approved,
        ];

        return view('reviewer.fullpapers', compact('fullPapers', 'stats'));
    }



    public function showFinalDecisionForm($paperId)
    {
        $paper = FullPaper::with([
            'abstract.subTheme',
            'reviewAssignments.prequalifiedReviewer',
            'reviewAssignments.peerReviewer',
            'reviewAssignments.fullPaperReview'
        ])->findOrFail($paperId);

        // Get ALL assignments (including those without reviews yet)
        $reviews = $paper->reviewAssignments;

        return view('reviewer.fullpapers-decision', compact('paper', 'reviews'));
    }
}
