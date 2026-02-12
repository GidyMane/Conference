<?php

namespace App\Http\Controllers;

use App\Models\SubmittedAbstract;
use App\Models\FullPaper;
use App\Models\SubTheme;
use Illuminate\Http\Request;

class FullPaperController extends Controller
{
   
    // PARTICIPANT UPLOAD FLOW
   

    public function create(Request $request, $id)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        $abstract = SubmittedAbstract::findOrFail($id);

        if ($abstract->status !== 'APPROVED') {
            abort(403, 'Abstract not approved.');
        }

        return view('full-papers.create', compact('abstract'));
    }

    public function store(Request $request, $id)
    {
        $abstract = SubmittedAbstract::findOrFail($id);

        if ($abstract->status !== 'APPROVED') {
            abort(403, 'Abstract not approved.');
        }

        $request->validate([
            'full_paper' => 'required|file|mimes:doc,docx,pdf,ppt,pptx|max:10240',
        ]);

        $nextNumber = FullPaper::where('submitted_abstract_id', $abstract->id)->count() + 1;
        $fullPaperCode = 'FP_' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $file = $request->file('full_paper');
        $fileName = "{$abstract->submission_code}-{$fullPaperCode}.{$file->getClientOriginalExtension()}";
        $destinationPath = public_path("full-papers/{$abstract->sub_theme_id}");

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $fileName);
        $relativePath = "full-papers/{$abstract->sub_theme_id}/{$fileName}";

        FullPaper::updateOrCreate(
            ['submitted_abstract_id' => $abstract->id],
            [
                'file_path' => $relativePath,
                'full_paper_code' => $fullPaperCode,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'uploaded_at' => now(),
                'status' => 'PENDING',
            ]
        );

        return redirect()->route('fullpapers.success', [
            'ref' => "{$abstract->submission_code}-{$fullPaperCode}"
        ]);
    }
  
    // ADMIN MANAGEMENT FLOW


    public function index(Request $request)
    {

        $fullPapers = FullPaper::with(['abstract', 'abstract.subTheme'])->get();

        $query = FullPaper::with(['abstract', 'abstract.subTheme']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', strtoupper($request->status));
        }

        // Filter by subtheme
        if ($request->filled('subtheme')) {
            $query->whereHas('abstract', function($q) use ($request) {
                $q->where('sub_theme_id', $request->subtheme);
            });
        }

        // Optional: filter by date range
        if ($request->filled('date_range')) {
            switch($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }
        }

        $fullPapers = $query->latest()->get();

        $stats = [
            'total'    => FullPaper::count(),
            'pending'  => FullPaper::where('status', 'PENDING')->count(),
            'accepted' => FullPaper::where('status', 'APPROVED')->count(),
            'rejected' => FullPaper::where('status', 'REJECTED')->count(),
        ];
        
        $subthemes = SubTheme::all();

        return view('admin.fullpapers.index', compact(
            'fullPapers',
            'stats',
            'subthemes'
        ));
    }
}
