<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FullPaper;
use App\Models\PresentationUpload;

class PresentationUploadController extends Controller
{

    public function showUploadForm($paperId)
    {
        $fullPaper = FullPaper::with('abstract')->findOrFail($paperId);

        if ($fullPaper->status !== 'APPROVED') {
            abort(403, 'Paper not approved for presentation.');
        }

        return view('powerpoint.presentation-upload', compact('fullPaper'));
    }


    public function upload(Request $request, $paperId)
    {
        $paper = FullPaper::findOrFail($paperId);

        if ($paper->status !== 'APPROVED') {
            abort(403);
        }

        $request->validate([
            'powerpoint_file' => 'nullable|mimes:ppt,pptx|max:20480',
            'poster_file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'supporting_docs.*' => 'nullable|mimes:pdf,doc,docx,zip|max:15360'
        ]);

        if (!$request->hasFile('powerpoint_file') && !$request->hasFile('poster_file')) {
            return back()->withErrors('Upload at least a PowerPoint OR Poster.');
        }

        $uploadedFiles = [];

        /*
        |--------------------------------------------------------------------------
        | PowerPoint
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('powerpoint_file')) {

            $file = $request->file('powerpoint_file');

            $name = 'ppt_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'presentations/ppt',
                $name,
                'public'
            );

            $uploadedFiles['powerpoint'] = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | Poster
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('poster_file')) {

            $file = $request->file('poster_file');

            $name = 'poster_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'presentations/posters',
                $name,
                'public'
            );

            $uploadedFiles['poster'] = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | Supporting Docs
        |--------------------------------------------------------------------------
        */

        $docs = [];

        if ($request->hasFile('supporting_docs')) {

            foreach ($request->file('supporting_docs') as $doc) {

                $name = time().'_'.$doc->getClientOriginalName();

                $path = $doc->storeAs(
                    'presentations/docs',
                    $name,
                    'public'
                );

                $docs[] = $path;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Save to database
        |--------------------------------------------------------------------------
        */

        PresentationUpload::updateOrCreate(
            ['full_paper_id' => $paper->id],
            [
                'powerpoint_file' => $uploadedFiles['powerpoint'] ?? null,
                'poster_file' => $uploadedFiles['poster'] ?? null,
                'supporting_documents' => $docs,
                'uploaded_at' => now()
            ]
        );

        return redirect()
            ->route('presentation.success', $paper->id)
            ->with([
                'uploaded_powerpoint' => $uploadedFiles['powerpoint'] ?? null,
                'uploaded_poster' => $uploadedFiles['poster'] ?? null,
                'uploaded_docs_count' => count($docs)
            ]);
    }


    public function success($paperId)
    {
        $fullPaper = FullPaper::with('abstract')->findOrFail($paperId);

        return view('powerpoint.presentation-upload-success', compact('fullPaper'));
    }

}