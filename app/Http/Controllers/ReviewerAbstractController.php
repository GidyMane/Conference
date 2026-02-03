<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubmittedAbstract as AbstractSubmission;
use App\Models\Reviewer;
use App\Models\Subtheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReviewerAbstractController extends Controller
{
    /**
     * Display a listing of the abstracts.
     */
    public function index(Request $request)
    {
        $query = AbstractSubmission::query()->with(['subtheme', 'reviewer']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subtheme')) {
            $query->where('subtheme_id', $request->subtheme);
        }

        if ($request->filled('reviewer')) {
            if ($request->reviewer === 'unassigned') {
                $query->whereNull('reviewer_id');
            } else {
                $query->where('reviewer_id', $request->reviewer);
            }
        }

        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }
        }

       // $abstracts = $query->orderBy('created_at', 'desc')->paginate(15);

        $subthemes = Subtheme::all();
        $reviewers = Reviewer::all();

        // Status counts for summary cards
        $statusCounts = [
            'pending' => AbstractSubmission::where('status', 'pending')->count(),
            'under_review' => AbstractSubmission::where('status', 'under_review')->count(),
            'approved' => AbstractSubmission::where('status', 'approved')->count(),
            'rejected' => AbstractSubmission::where('status', 'rejected')->count(),
        ];

        return view('reviewer.abstracts.index', compact('subthemes', 'reviewers', 'statusCounts'));
    }

    /**
     * Show a single abstract.
     */
    public function show($id)
    {
        $abstract = AbstractSubmission::with(['subtheme', 'reviewer', 'authors', 'reviews.reviewer'])->findOrFail($id);
        $reviewers = Reviewer::all();

        return view('reviewer.abstracts.show', compact('abstract', 'reviewers'));
    }

    /**
     * Assign a reviewer to an abstract.
     */
    public function assignReviewer(Request $request)
    {
        $request->validate([
            'abstract_id' => 'required|exists:abstract_submissions,id',
            'reviewer_id' => 'required|exists:reviewers,id',
        ]);

        $abstract = AbstractSubmission::findOrFail($request->abstract_id);
        $abstract->reviewer_id = $request->reviewer_id;
        $abstract->status = 'under_review';
        $abstract->save();

        // TODO: send notification email if needed

        return response()->json(['success' => true, 'message' => 'Reviewer assigned successfully.']);
    }

    /**
     * Change status of an abstract.
     */
    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
        ]);

        $abstract = AbstractSubmission::findOrFail($id);
        $abstract->status = $request->status;
        $abstract->save();

        // TODO: send notification to author if needed

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    /**
     * Approve an abstract.
     */
    public function approve($id)
    {
        $abstract = AbstractSubmission::findOrFail($id);
        $abstract->status = 'approved';
        $abstract->reviewed_at = now();
        $abstract->save();

        // TODO: notify author to submit full paper

        return response()->json(['success' => true, 'message' => 'Abstract approved successfully.']);
    }

    /**
     * Reject an abstract.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $abstract = AbstractSubmission::findOrFail($id);
        $abstract->status = 'rejected';
        $abstract->rejection_reason = $request->rejection_reason;
        $abstract->reviewed_at = now();
        $abstract->save();

        // TODO: notify author via email if needed

        return response()->json(['success' => true, 'message' => 'Abstract rejected successfully.']);
    }

    /**
     * Delete an abstract.
     */
    public function destroy($id)
    {
        $abstract = AbstractSubmission::findOrFail($id);
        $abstract->delete();

        return response()->json(['success' => true, 'message' => 'Abstract deleted successfully.']);
    }

    /**
     * Export abstracts as CSV.
     */
    public function export(Request $request)
    {
        $query = AbstractSubmission::query()->with(['subtheme', 'reviewer']);

        // Apply filters like in index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subtheme')) {
            $query->where('subtheme_id', $request->subtheme);
        }

        if ($request->filled('reviewer')) {
            if ($request->reviewer === 'unassigned') {
                $query->whereNull('reviewer_id');
            } else {
                $query->where('reviewer_id', $request->reviewer);
            }
        }

        $abstracts = $query->get();

        $filename = 'abstracts_export_' . now()->format('Ymd_His') . '.csv';
        $columns = ['Submission ID', 'Title', 'Author', 'Subtheme', 'Status', 'Reviewer', 'Submitted At'];

        $callback = function () use ($abstracts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($abstracts as $abstract) {
                fputcsv($file, [
                    $abstract->submission_id,
                    $abstract->title,
                    $abstract->author_name,
                    $abstract->subtheme->name ?? 'N/A',
                    $abstract->status,
                    $abstract->reviewer->name ?? 'Unassigned',
                    $abstract->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
