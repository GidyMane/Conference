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

            // Save or update review (1 per reviewer)
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
            $abstract->update([
                'status' => $request->decision,
            ]);

            // Generate upload link ONLY if approved
            $uploadUrl = null;
            if ($request->decision === 'APPROVED') {
                $uploadUrl = URL::temporarySignedRoute(
                    'full-papers.create',
                    now()->addDays(14),
                    ['abstract' => $abstract->id]
                );
            }

            // Email author
            Mail::to($abstract->author_email)
                ->send(new AbstractReviewedMail(
                    $abstract,
                    $request->comment,
                    $uploadUrl
                ));

            //  Return JSON for JS
            return response()->json([
                'status' => 'success',
                'message' => 'Review submitted successfully!'
            ]);

        } catch (\Exception $e) {
            // Return JSON even on error
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
