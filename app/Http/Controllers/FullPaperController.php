<?php

namespace App\Http\Controllers;

use App\Models\SubmittedAbstract;
use App\Models\FullPaper;
use App\Models\SubTheme;
use Illuminate\Http\Request;

class FullPaperController extends Controller
{
    // =========================
    // PARTICIPANT UPLOAD FLOW
    // =========================

    public function create(Request $request, SubmittedAbstract $abstract)
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        if ($abstract->status !== 'APPROVED') {
            abort(403, 'Abstract not approved.');
        }

        return view('full-papers.create', compact('abstract'));
    }

    public function store(Request $request, SubmittedAbstract $abstract)
    {
        $request->validate([
            'full_paper' => 'required|file|mimes:doc,docx,pdf,ppt,pptx|max:10240',
        ]);

        $path = $request->file('full_paper')
            ->store("full-papers/{$abstract->sub_theme_id}", 'public');

        FullPaper::updateOrCreate(
            ['submitted_abstract_id' => $abstract->id],
            [
                'file_path'   => $path,
                'file_type'   => $request->file('full_paper')->getClientOriginalExtension(),
                'file_size'   => $request->file('full_paper')->getSize(),
                'uploaded_at' => now(),
                'status'      => 'pending', // 👈 important for admin review
            ]
        );

        return back()->with('success', 'Full paper uploaded successfully.');
    }

    // =========================
    // ADMIN MANAGEMENT FLOW
    // =========================

    public function index(Request $request)
    {
        $query = FullPaper::with([
            'abstract',
            'abstract.subTheme',
        ]);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subtheme')) {
            $query->whereHas('abstract', function ($q) use ($request) {
                $q->where('sub_theme_id', $request->subtheme);
            });
        }

        $fullPapers = $query->latest()->get();

        $stats = [
            'total'   => FullPaper::count(),
            'pending' => FullPaper::where('status', 'pending')->count(),
            'accepted'=> FullPaper::where('status', 'accepted')->count(),
            'rejected'=> FullPaper::where('status', 'rejected')->count(),
        ];

        $subthemes = SubTheme::all();

        return view('admin.fullpapers.index', compact(
            'fullPapers',
            'stats',
            'subthemes'
        ));
    }
}
