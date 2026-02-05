<?php

namespace App\Http\Controllers;

use App\Models\SubmittedAbstract;
use App\Models\AbstractCoAuthor;
use App\Models\SubTheme;
use App\Mail\AbstractSubmittedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AbstractSubmissionController extends Controller
{
        public function store(Request $request)
    {
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

        DB::transaction(function () use ($request, &$submissionCode) {

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
                'status' => 'PENDING',
            ]);

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

            try {
                Mail::to($abstract->author_email)
                    ->send(new AbstractSubmittedMail($abstract));

                session()->flash('email_sent', true);
                session()->flash('corresponding_email', $abstract->author_email);
            } catch (\Exception $e) {
                session()->flash('email_error', true);
            }
        });

        return redirect()->route('abstracts.success', [
            'ref' => $submissionCode
        ]);
    }
}
