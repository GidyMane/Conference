<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use App\Models\AbstractAssignment;
use App\Models\AbstractReview;
use App\Models\AbstractCoAuthor;
use App\Models\SubTheme;
use App\Models\ConferenceRegistration;
use App\Models\ExhibitionRegistration;


class AdminController extends Controller
{
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
