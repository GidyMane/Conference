<?php

namespace App\Http\Controllers;

use App\Models\SubmittedAbstract;
use App\Models\FullPaper;
use App\Models\SubTheme;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FullPaperController extends Controller
{
   
    // PARTICIPANT UPLOAD FLOW
   

    public function create($id)
    {
        $abstract = SubmittedAbstract::findOrFail($id);

        if ($abstract->status !== 'APPROVED') {
            abort(403, 'Abstract not approved.');
        }

        return view('full-papers.create', compact('abstract'));
    }

public function store(Request $request, $id)
{
    try {
        $abstract = SubmittedAbstract::findOrFail($id);

        if ($abstract->status !== 'APPROVED') {
            abort(403, 'Abstract not approved.');
        }

        // 🔍 STEP 1: Check if file exists at all
        if (!$request->hasFile('full_paper')) {
            return back()->withErrors([
                'full_paper' => 'No file was received from the form. Check input name or enctype.'
            ]);
        }

        $file = $request->file('full_paper');

        // 🔍 STEP 2: Show what Laravel is actually receiving
        $debugInfo = [
            'original_name' => $file->getClientOriginalName(),
            'extension'     => $file->getClientOriginalExtension(),
            'mime_type'     => $file->getMimeType(),
            'size_bytes'    => $file->getSize(),
        ];

        // 🔍 STEP 3: Validate with clearer error reporting
        $validator = validator($request->all(), [
            'full_paper' => 'required|file|mimes:doc,docx,pdf,ppt,pptx|max:10240',
        ]);

        if ($validator->fails()) {
            return back()->withErrors([
                'full_paper' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                'debug' => json_encode($debugInfo),
            ]);
        }

        // =========================
        // If we reach here → file is valid
        // =========================

        $nextNumber = FullPaper::where('submitted_abstract_id', $abstract->id)->count() + 1;
        $fullPaperCode = 'FP_' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $fileSize = $file->getSize();
        $extension = $file->getClientOriginalExtension();

        $fileName = "{$abstract->submission_code}-{$fullPaperCode}.{$extension}";

        $path = $file->storeAs(
            "uploads/full-papers/{$abstract->sub_theme_id}",
            $fileName,
            'public'
        );

        // Create AUTHOR user automatically if not exists
        User::firstOrCreate(
            ['email' => $abstract->author_email],
            [
                'full_name' => $abstract->author_name,
                'role' => 'AUTHOR',
                'password' => null,
                'is_active' => true,
                'password_setup_token' => Str::random(64),
                'password_setup_expires_at' => now()->addDays(14),
            ]
        );

        FullPaper::updateOrCreate(
            ['submitted_abstract_id' => $abstract->id],
            [
                'file_path'       => $path,
                'full_paper_code' => $fullPaperCode,
                'file_type'       => $extension,
                'file_size'       => $fileSize,
                'uploaded_at'     => now(),
                'status'          => 'PENDING',
            ]
        );

        return redirect()->route('fullpapers.success', [
            'ref' => "{$abstract->submission_code}-{$fullPaperCode}"
        ]);

    } catch (\Throwable $e) {
        // 🔥 THIS SHOWS THE REAL ERROR
        return back()->withErrors([
            'full_paper' => 'SYSTEM ERROR: ' . $e->getMessage()
        ]);
    }
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
