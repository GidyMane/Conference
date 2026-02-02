<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use App\Models\AbstractAssignment;
use App\Models\AbstractReview;
use App\Models\SubTheme;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'totalSubmissions'   => SubmittedAbstract::count(),
            'totalAuthors'       => AbstractAssignment::count(),
            'approvedCount'      => SubmittedAbstract::where('status', 'approved')->count(),
            'disapprovedCount'   => SubmittedAbstract::where('status', 'disapproved')->count(),
            'pendingCount'       => SubmittedAbstract::where('status', 'pending')->count(),
            'reviewCount'        => SubmittedAbstract::where('status', 'under_review')->count(),
            'revisionCount'      => SubmittedAbstract::where('status', 'revision_requested')->count(),
            'oralCount'          => AbstractReview::where('decision', 'oral')->count(),
            'posterCount'        => AbstractReview::where('decision', 'poster')->count(),
        ];

        $cards = [
            ["Total Submissions", $metrics['totalSubmissions'], "fa-file-alt", "total"],
            ["Total Authors", $metrics['totalAuthors'], "fa-users", "total"],
            ["Approved Abstracts", $metrics['approvedCount'], "fa-check-circle", "approved"],
            ["Disapproved Abstracts", $metrics['disapprovedCount'], "fa-times-circle", "disapproved"],
            ["Pending Review", $metrics['pendingCount'], "fa-clock", "pending"],
            ["Under Review", $metrics['reviewCount'], "fa-search", "review"],
            ["Revision Requested", $metrics['revisionCount'], "fa-redo", "revision"],
            ["Oral Presentations", $metrics['oralCount'], "fa-microphone", "total"],
            ["Poster Presentations", $metrics['posterCount'], "fa-image", "total"]
        ];

        $chartData = [
            'status' => SubmittedAbstract::selectRaw('status, COUNT(*) as t')->groupBy('status')->get()->toArray(),
            'subTheme' => SubmittedAbstract::selectRaw('sub_theme_id, COUNT(*) as t')->groupBy('sub_theme_id')->get()->toArray(),
            'presentation' => SubmittedAbstract::selectRaw('presentation_preference, COUNT(*) as t')->groupBy('presentation_preference')->get()->toArray(),
            'attendance' => SubmittedAbstract::selectRaw('attendance_mode, COUNT(*) as t')->groupBy('attendance_mode')->get()->toArray(),
            'dates' => SubmittedAbstract::selectRaw('DATE(created_at) as d, COUNT(*) as t')->groupBy('d')->get()->toArray(),
            #'submissionTypes' => SubmittedAbstract::selectRaw('submission_type, COUNT(*) as t')->groupBy('submission_type')->get()->toArray(),
            #'institutions' => SubmittedAbstract::selectRaw('organization, COUNT(*) as t')->groupBy('organization')->get()->toArray(),
            #'authors' => SubmittedAbstract::selectRaw('id as submission_id, COUNT(author_id) as t')->groupBy('id')->get()->toArray(),
        ];

        $recentSubmissionsData = SubmittedAbstract::latest()
            ->take(5)
            ->get(['paper_title', 'submission_code', 'status', 'created_at'])
            ->toArray(); 

        return view('admin.dashboard', compact('metrics', 'cards', 'recentSubmissionsData', 'chartData'));
    }

    public function abstracts()
    {

        $sub_themes = SubTheme::pluck('full_name');

        return view('admin.abstracts', compact('sub_themes'));
    }
}
