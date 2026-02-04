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

        // 1️⃣ Fetch full papers linked to abstracts assigned to this reviewer
        $fullPapers = FullPaper::with(['abstract.subTheme'])
            ->whereHas('abstract.assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId);
            })
            ->latest()
            ->paginate(10); // Pagination, adjust per your needs

        // 2️⃣ Total abstracts assigned to this reviewer
        $totalAssigned = SubmittedAbstract::whereHas('assignments', function ($q) use ($reviewerId) {
            $q->where('reviewer_id', $reviewerId);
        })->count();

        // 3️⃣ Full papers submitted for assigned abstracts
        $submitted = FullPaper::whereHas('abstract.assignments', function ($q) use ($reviewerId) {
            $q->where('reviewer_id', $reviewerId);
        })->count();

        // 4️⃣ Pending = assigned abstracts approved but without a full paper
        $pending = SubmittedAbstract::whereHas('assignments', function ($q) use ($reviewerId) {
                $q->where('reviewer_id', $reviewerId)
                  ->where('status', 'approved'); // only approved abstracts
            })
            ->whereDoesntHave('fullPaper')
            ->count();

        // 5️⃣ Approved = full papers that have been approved
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

    /**
     * Show details of a specific full paper (dummy)
     */
    public function show($id)
    {
        $paper = (object)[
            'id' => $id,
            'submitted_abstract_id' => 'AB-001',
            'status' => 'pending',
            'paper_file_path' => 'dummy/paper1.pdf',
            'presentation_file_path' => 'dummy/ppt1.pptx',
            'supplementary_files_path' => json_encode(['dummy/supp1.docx']),
            'created_at' => now()->subDays(2),
            'abstract' => (object)[
                'submission_code' => 'AB-001',
                'paper_title' => 'AI in Agriculture',
                'author_name' => 'John Doe',
                'author_email' => 'john@example.com',
                'subTheme' => (object)['name' => 'Technology in Farming'],
            ],
        ];

        return view('reviewer.fullpapers.show', compact('paper'));
    }
}
