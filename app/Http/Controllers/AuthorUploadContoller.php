<?php

namespace App\Http\Controllers;

use App\Models\FullPaper;
use App\Models\FullPaperDecision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorUploadController extends Controller
{
    /**
     * Show upload form via token
     */
    public function showUploadForm($token)
    {
        $decision = FullPaperDecision::where('upload_token', $token)
            ->where('upload_token_expires_at', '>', now())
            ->where('decision', 'approved')
            ->with(['fullPaper.abstract'])
            ->firstOrFail();

        $paper = $decision->fullPaper;

        return view('author.upload-presentation', compact('decision', 'paper', 'token'));
    }

    /**
     * Handle presentation upload
     */
    public function uploadPresentation(Request $request, $token)
    {
        $decision = FullPaperDecision::where('upload_token', $token)
            ->where('upload_token_expires_at', '>', now())
            ->where('decision', 'approved')
            ->firstOrFail();

        $validated = $request->validate([
            'powerpoint_file' => 'nullable|file|mimes:ppt,pptx|max:20480', // 20MB
            'poster_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB
        ]);

        // At least one file must be uploaded
        if (!$request->hasFile('powerpoint_file') && !$request->hasFile('poster_file')) {
            return back()->with('error', 'Please upload at least one file (PowerPoint or Poster).');
        }

        $paper = $decision->fullPaper;

        // Store PowerPoint
        if ($request->hasFile('powerpoint_file')) {
            // Delete old file if exists
            if ($paper->powerpoint_file_path && Storage::exists($paper->powerpoint_file_path)) {
                Storage::delete($paper->powerpoint_file_path);
            }

            $pptPath = $request->file('powerpoint_file')->store('fullpapers/presentations', 'public');
            $paper->powerpoint_file_path = $pptPath;
        }

        // Store Poster
        if ($request->hasFile('poster_file')) {
            // Delete old file if exists
            if ($paper->poster_file_path && Storage::exists($paper->poster_file_path)) {
                Storage::delete($paper->poster_file_path);
            }

            $posterPath = $request->file('poster_file')->store('fullpapers/posters', 'public');
            $paper->poster_file_path = $posterPath;
        }

        $paper->presentation_uploaded_at = now();
        $paper->save();

        return view('author.upload-success', compact('paper'));
    }
}