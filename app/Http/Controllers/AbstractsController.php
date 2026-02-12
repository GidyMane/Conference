<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use App\Models\AbstractReview;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbstractReviewedMail;
use Illuminate\Support\Facades\URL;

class AbstractsController extends Controller
{
    public function review(Request $request)
    {
        $request->validate([
            'abstract_id' => 'required|exists:submitted_abstracts,id',
            'decision' => 'required|in:APPROVED,REJECTED',
            'comment' => 'required|string',
        ]);

        try {
            $abstract = SubmittedAbstract::findOrFail($request->abstract_id);

            $reviewerId = auth()->id() ?? 1;

            // Save or update review
            AbstractReview::updateOrCreate(
                [
                    'abstract_id' => $abstract->id,
                    'reviewer_id' => $reviewerId,
                ],
                [
                    'comment' => $request->comment,
                    'decision' => $request->decision,
                    'reviewed_at' => now(),
                ]
            );

            // Update abstract status
            $abstract->update(['status' => $request->decision]);

            // Generate signed upload URL if approved
            $uploadUrl = null;
            if ($request->decision === 'APPROVED') {
                $uploadUrl = route('full-papers.create', [
                    'abstract' => $abstract->id
                ]);
            }

            // Send email
            Mail::to($abstract->author_email)
                ->send(new AbstractReviewedMail($abstract, $request->comment, $uploadUrl));

            return response()->json([
                'status' => 'success',
                'message' => 'Review submitted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}