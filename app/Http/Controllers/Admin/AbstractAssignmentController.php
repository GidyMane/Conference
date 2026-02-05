<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubmittedAbstract;
use App\Models\AbstractAssignment;

class AbstractAssignmentController extends Controller
{
    // Fetch reviewer info and available abstracts
   public function availableAbstracts(User $reviewer)
    {
        if ($reviewer->role !== 'REVIEWER') {
            return response()->json(['message' => 'User is not a reviewer.'], 400);
        }

        $reviewer->load('reviewer.subTheme');

        $subthemeId = $reviewer->reviewer->sub_theme_id ?? null;

        $assignedAbstractIds = AbstractAssignment::where('reviewer_id', $reviewer->id)
            ->pluck('abstract_id')
            ->toArray();

        $abstracts = $subthemeId
            ? SubmittedAbstract::where('sub_theme_id', $subthemeId)
                ->whereNotIn('id', $assignedAbstractIds)
                ->get(['id', 'submission_code', 'paper_title as title'])
            : [];

        return response()->json([
            'reviewer' => $reviewer,
            'abstracts' => $abstracts,
        ]);
    }
    // Assign selected abstracts to reviewer
    public function assign(Request $request)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'abstracts'   => 'required|array',
            'abstracts.*' => 'exists:submitted_abstracts,id',
        ]);

        $reviewer = User::findOrFail($request->reviewer_id);

        foreach ($request->abstracts as $abstractId) {

            // Assign reviewer (no duplicates)
            AbstractAssignment::firstOrCreate([
                'abstract_id' => $abstractId,
                'reviewer_id' => $reviewer->id,
            ]);

            // FORCE status to UNDER_REVIEW if not final
            SubmittedAbstract::where('id', $abstractId)
                ->whereIn('status', ['PENDING']) // keep strict for now
                ->update([
                    'status' => 'UNDER_REVIEW',
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Abstracts assigned and moved to UNDER REVIEW.',
        ]);
    }

}
