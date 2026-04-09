<?php

namespace App\Http\Controllers;

use App\Models\SubmittedAbstract;
use App\Models\AbstractCoAuthor;
use App\Models\SubTheme;
use App\Mail\AbstractSubmittedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\AbstractAssignment;
use App\Models\Reviewer;
use App\Mail\AbstractAssignedMail;
use App\Mail\AbstractSubmittedSecretariatMail;
use App\Exports\AdminAbstractsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AbstractSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $deadline = Carbon::create(2026, 3, 27, 23, 59, 59);

        if (now()->gt($deadline)) {
            return redirect()->back()->with('error', 'Submission deadline has passed.');
        }
        
        $request->validate([
            'author_name'   => 'required|string|max:255',
            'author_email'  => 'required|email|max:255',
            'author_phone'  => 'required|string|max:20',
            'organisation'  => 'required|string|max:255',
            'sub_theme'     => 'required|exists:sub_themes,id',
            'paper_title'   => 'required|string|max:255',
            'abstract_text' => 'required|string|max:3000',
            'terms'         => 'accepted',
        ]);

        $submissionCode = null;
        $abstract = null;
        $reviewerUser = null;

        DB::transaction(function () use ($request, &$submissionCode, &$abstract, &$reviewerUser) {

            // Retry logic built into generateSubmissionCode
            $submissionCode = SubmittedAbstract::generateSubmissionCode($request->sub_theme);

            $abstract = SubmittedAbstract::create([
                'submission_code' => $submissionCode,
                'author_name'     => $request->author_name,
                'author_email'    => $request->author_email,
                'author_phone'    => $request->author_phone,
                'organisation'    => $request->organisation,
                'department'      => $request->department,
                'position'        => $request->position,
                'sub_theme_id'    => $request->sub_theme,
                'paper_title'     => $request->paper_title,
                'abstract_text'   => $request->abstract_text,
                'keywords'        => $request->keywords,
                'presentation_preference' => $request->presentation_preference
                    ? strtoupper($request->presentation_preference)
                    : null,
                'attendance_mode' => $request->attendance_mode
                    ? strtoupper($request->attendance_mode)
                    : null,
                'special_requirements' => $request->special_requirements,
                'status' => 'UNDER_REVIEW',
            ]);

            // Assign reviewer if available
            $reviewer = Reviewer::with('user')
                ->whereHas('subThemes', fn($q) => $q->where('sub_themes.id', $request->sub_theme))
                ->first();

            if ($reviewer && $reviewer->user) {
                AbstractAssignment::create([
                    'abstract_id' => $abstract->id,
                    'reviewer_id' => $reviewer->user_id,
                    'assigned_at' => now(),
                ]);

                $reviewerUser = $reviewer->user; // for email
            }

            // Save co-authors if provided
            if ($request->has('authors')) {
                foreach ($request->authors as $order => $author) {
                    AbstractCoAuthor::create([
                        'abstract_id' => $abstract->id,
                        'full_name'   => $author['name'],
                        'institution' => $author['institution'] ?? null,
                        'author_order'=> $order,
                    ]);
                }
            }
        });

        /* 📧 SEND EMAILS AFTER TRANSACTION */

        if ($reviewerUser) {
            try {
                Mail::to($reviewerUser->email)
                    ->send(new AbstractAssignedMail($reviewerUser, $abstract));
            } catch (\Throwable $e) {
                \Log::error('Reviewer email failed', ['error' => $e->getMessage()]);
            }
        }

        try {
            Mail::to($abstract->author_email)
                ->send(new AbstractSubmittedMail($abstract));
        } catch (\Throwable $e) {
            \Log::error('Author confirmation email failed', ['error' => $e->getMessage()]);
        }

        try {
            Mail::to(config('mail.secretariat_address', 'kalroconference2026@gmail.com'))
                ->send(new AbstractSubmittedSecretariatMail($abstract));
        } catch (\Throwable $e) {
            \Log::error('Secretariat notification email failed', ['error' => $e->getMessage()]);
        }

        return redirect()->route('abstracts.success', [
            'ref' => $submissionCode
        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(
            new AdminAbstractsExport($request->all()),
            'admin_abstracts_' . now()->format('Y_m_d_H_i_s') . '.xlsx'
        );
    }
}