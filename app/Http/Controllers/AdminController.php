<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use App\Models\AbstractAssignment;
use App\Models\AbstractReview;
use App\Models\AbstractCoAuthor;
use App\Models\SubTheme;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'totalSubmissions'   => SubmittedAbstract::count(),
            'totalAuthors'       => AbstractCoAuthor::count(),
            'approvedCount'      => SubmittedAbstract::where('status', 'approved')->count(),
            'disapprovedCount'   => SubmittedAbstract::where('status', 'rejected')->count(),
            'pendingCount'       => SubmittedAbstract::where('status', 'pending')->count(),
            'reviewCount'        => SubmittedAbstract::where('status', 'under_review')->count(),
            'subThemeCount'      => SubTheme::count(),
            'oralCount'          => SubmittedAbstract::where('presentation_preference', 'oral')->count(),
            'posterCount'        => SubmittedAbstract::where('presentation_preference', 'poster')->count(),
        ];

        $cards = [
            ["Total Submissions", $metrics['totalSubmissions'], "fa-file-alt", "total"],
            ["Total Authors", $metrics['totalAuthors'], "fa-users", "total"],
            ["Approved Abstracts", $metrics['approvedCount'], "fa-check-circle", "approved"],
            ["Disapproved Abstracts", $metrics['disapprovedCount'], "fa-times-circle", "disapproved"],
            ["Pending Review", $metrics['pendingCount'], "fa-clock", "pending"],
            ["Under Review", $metrics['reviewCount'], "fa-search", "review"],
            ["Sub Themes", $metrics['subThemeCount'], "fa-redo", "revision"],
            ["Oral Presentations", $metrics['oralCount'], "fa-microphone", "total"],
            ["Poster Presentations", $metrics['posterCount'], "fa-image", "total"]
        ];

        $chartData = [
            'status' => SubmittedAbstract::selectRaw('status, COUNT(*) as t')->groupBy('status')->get()->toArray(),
            'subTheme' => SubmittedAbstract::selectRaw('sub_theme_id, COUNT(*) as t')->groupBy('sub_theme_id')->get()->toArray(),
            'presentation' => SubmittedAbstract::selectRaw('presentation_preference, COUNT(*) as t')->groupBy('presentation_preference')->get()->toArray(),
            'attendance' => SubmittedAbstract::selectRaw('attendance_mode, COUNT(*) as t')->groupBy('attendance_mode')->get()->toArray(),
            'dates' => SubmittedAbstract::selectRaw('DATE(created_at) as d, COUNT(*) as t')->groupBy('d')->get()->toArray(),
           
        ];

        $recentSubmissionsData = SubmittedAbstract::latest()
            ->take(5)
            ->get(['paper_title', 'submission_code', 'status', 'created_at'])
            ->toArray(); 

       $totalSubmissions = SubmittedAbstract::count();

        return view('admin.dashboard', compact('metrics', 'cards', 'recentSubmissionsData', 'chartData', 'totalSubmissions'));
    }
    public function abstracts(Request $request)
{
    $sub_themes = SubTheme::all();

    $statuses = [
        'PENDING' => 'Pending',
        'UNDER_REVIEW' => 'Under Review',
        'APPROVED' => 'Approved',
        'REJECTED' => 'Rejected',
    ];

    $query = SubmittedAbstract::with(['subTheme', 'latestReview']);

    if ($request->filled('sub_theme')) {
        $query->where('sub_theme_id', $request->sub_theme);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    // PAGINATION (latest first)
    $abstracts = $query
        ->orderByDesc('created_at')
        ->paginate(10)
        ->withQueryString();

    $totalSubmissions = SubmittedAbstract::count();

    return view(
        'admin.abstracts',
        compact('sub_themes', 'statuses', 'abstracts', 'totalSubmissions')
    );
}


    public function dashboard2()
    {
        return view('admin.dashboard2');
    }
    public function abstracts2()
    {
        return view('admin.abstracts.index');
    }
}
