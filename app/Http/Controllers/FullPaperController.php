<?php

namespace App\Http\Controllers;

use App\Models\SubmittedAbstract;
use App\Models\FullPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FullPaperController extends Controller
{
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
                'file_path' => $path,
                'file_type' => $request->file('full_paper')->getClientOriginalExtension(),
                'file_size' => $request->file('full_paper')->getSize(),
                'uploaded_at' => now(),
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Full paper uploaded successfully.');
    }
}
