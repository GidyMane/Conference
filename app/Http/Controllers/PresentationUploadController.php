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
            'revised_fullpaper' => 'required|mimes:pdf,doc,docx|max:15360',
            'powerpoint_file'   => 'nullable|mimes:ppt,pptx|max:20480',
            'poster_file'       => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'supporting_docs.*' => 'nullable|mimes:pdf,doc,docx,zip|max:15360'
        ]);

        $uploadedFiles = [];

        // Revised Full Paper
        if ($request->hasFile('revised_fullpaper')) {
            $file = $request->file('revised_fullpaper');
            $name = 'revised_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('presentations/revised', $name, 'public');
            $uploadedFiles['revised_fullpaper'] = $path;
        }

        // PowerPoint
        if ($request->hasFile('powerpoint_file')) {
            $file = $request->file('powerpoint_file');
            $name = 'ppt_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('presentations/ppt', $name, 'public');
            $uploadedFiles['powerpoint_file'] = $path;
        }

        // Poster
        if ($request->hasFile('poster_file')) {
            $file = $request->file('poster_file');
            $name = 'poster_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('presentations/posters', $name, 'public');
            $uploadedFiles['poster_file'] = $path;
        }

        // Supporting Documents
        $docs = [];
        if ($request->hasFile('supporting_docs')) {
            foreach ($request->file('supporting_docs') as $doc) {
                $name = time().'_'.$doc->getClientOriginalName();
                $path = $doc->storeAs('presentations/docs', $name, 'public');
                $docs[] = $path;
            }
        }

        // Save or update
        PresentationUpload::updateOrCreate(
            ['full_paper_id' => $paper->id],
            [
                'revised_fullpaper' => $uploadedFiles['revised_fullpaper'] ?? null,
                'powerpoint_file'   => $uploadedFiles['powerpoint_file'] ?? null,
                'poster_file'       => $uploadedFiles['poster_file'] ?? null,
                'supporting_documents' => $docs,
                'uploaded_at'       => now()
            ]
        );

        return redirect()->route('presentation.success', $paper->id)
                         ->with('message', 'Presentation files uploaded successfully.');
    }


    public function success($paperId)
    {
        $fullPaper = FullPaper::with('abstract')->findOrFail($paperId);

        return view('powerpoint.presentation-upload-success', compact('fullPaper'));
    }

    public function viewMaterials($id)
    {
        $fullPaper = FullPaper::with(['abstract.subTheme','presentationUpload'])->findOrFail($id);

        $upload = PresentationUpload::where('full_paper_id', $id)->first();

        $powerpoint = null;
        $poster = null;
        $supportingDocs = [];
        $activities = [];
        $revised = null;

        if ($upload && $upload->revised_fullpaper) {
            $revised = (object)[
                'original_name' => basename($upload->revised_fullpaper),
                'download_url' => asset('storage/'.$upload->revised_fullpaper),
                'size' => 'File'
            ];

            $activities[] = [
                'icon' => 'fa-upload',
                'color' => 'text-primary',
                'title' => 'Revised full paper uploaded',
                'description' => basename($upload->revised_fullpaper),
                'time' => $upload->created_at
            ];
        }

        if ($upload) {

            if ($upload->powerpoint_file) {
                $powerpoint = (object)[
                    'original_name' => basename($upload->powerpoint_file),
                    'download_url' => asset('storage/'.$upload->powerpoint_file),
                    'size' => 'File'
                ];

                $activities[] = [
                    'icon' => 'fa-upload',
                    'color' => 'text-primary',
                    'title' => 'PowerPoint uploaded',
                    'description' => basename($upload->powerpoint_file),
                    'time' => $upload->created_at
                ];
            }

            if ($upload->poster_file) {
                $poster = (object)[
                    'original_name' => basename($upload->poster_file),
                    'download_url' => asset('storage/'.$upload->poster_file),
                    'size' => 'File'
                ];

                $activities[] = [
                    'icon' => 'fa-upload',
                    'color' => 'text-primary',
                    'title' => 'Poster uploaded',
                    'description' => basename($upload->poster_file),
                    'time' => $upload->created_at
                ];
            }

            if ($upload->supporting_documents) {

                foreach ($upload->supporting_documents as $index => $doc) {
                    $supportingDocs[] = (object)[
                        'id' => $index+1,
                        'original_name' => basename($doc),
                        'download_url' => asset('storage/'.$doc),
                        'size' => 'File'
                    ];
                }

                $activities[] = [
                    'icon' => 'fa-upload',
                    'color' => 'text-primary',
                    'title' => count($upload->supporting_documents).' supporting documents uploaded',
                    'description' => null,
                    'time' => $upload->created_at
                ];
            }
        }

        // Paper approval log
        if ($fullPaper->status === 'approved') {
            $activities[] = [
                'icon' => 'fa-check-circle',
                'color' => 'text-success',
                'title' => 'Paper approved for presentation',
                'description' => null,
                'time' => $fullPaper->updated_at
            ];
        }

        // Sort newest first
        usort($activities, fn($a,$b) => $b['time'] <=> $a['time']);

        return view('reviewer.presentation-materials', compact(
            'fullPaper',
            'powerpoint',
            'poster',
            'supportingDocs',
            'revised', 
            'activities'
        ));
    }


    public function adminViewMaterials($id)
{
    $fullPaper = FullPaper::with(['abstract.subTheme', 'presentationUpload'])->findOrFail($id);

    $upload = PresentationUpload::where('full_paper_id', $id)->first();

    $powerpoint     = null;
    $poster         = null;
    $supportingDocs = [];
    $activities     = [];
    $revised        = null;
    $uploadDate     = $upload?->created_at;

    if ($upload) {

        if ($upload->revised_fullpaper) {
            $revised = (object)[
                'original_name' => basename($upload->revised_fullpaper),
                'download_url'  => asset('storage/' . $upload->revised_fullpaper),
                'size'          => 'File',
            ];
            $activities[] = [
                'icon'        => 'fa-file-alt',
                'color'       => 'text-success',
                'title'       => 'Revised full paper uploaded',
                'description' => basename($upload->revised_fullpaper),
                'time'        => $upload->created_at,
            ];
        }

        if ($upload->powerpoint_file) {
            $powerpoint = (object)[
                'original_name' => basename($upload->powerpoint_file),
                'download_url'  => asset('storage/' . $upload->powerpoint_file),
                'size'          => 'File',
            ];
            $activities[] = [
                'icon'        => 'fa-file-powerpoint',
                'color'       => 'text-warning',
                'title'       => 'PowerPoint presentation uploaded',
                'description' => basename($upload->powerpoint_file),
                'time'        => $upload->created_at,
            ];
        }

        if ($upload->poster_file) {
            $poster = (object)[
                'original_name' => basename($upload->poster_file),
                'download_url'  => asset('storage/' . $upload->poster_file),
                'size'          => 'File',
            ];
            $activities[] = [
                'icon'        => 'fa-image',
                'color'       => 'text-primary',
                'title'       => 'Poster uploaded',
                'description' => basename($upload->poster_file),
                'time'        => $upload->created_at,
            ];
        }

        if ($upload->supporting_documents) {
            foreach ($upload->supporting_documents as $index => $doc) {
                $supportingDocs[] = (object)[
                    'id'            => $index + 1,
                    'original_name' => basename($doc),
                    'download_url'  => asset('storage/' . $doc),
                    'size'          => 'File',
                ];
            }
            $activities[] = [
                'icon'        => 'fa-paperclip',
                'color'       => 'text-secondary',
                'title'       => count($upload->supporting_documents) . ' supporting document(s) uploaded',
                'description' => null,
                'time'        => $upload->created_at,
            ];
        }
    }

    if (in_array(strtolower($fullPaper->status), ['approved'])) {
        $activities[] = [
            'icon'        => 'fa-check-circle',
            'color'       => 'text-success',
            'title'       => 'Paper approved for presentation',
            'description' => null,
            'time'        => $fullPaper->updated_at,
        ];
    }

    usort($activities, fn($a, $b) => $b['time'] <=> $a['time']);

    return view('admin.presentation-materials', compact(
        'fullPaper',
        'powerpoint',
        'poster',
        'supportingDocs',
        'revised',
        'uploadDate',
        'activities'
    ));
}

}