<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubmittedAbstract;
use App\Models\AbstractAssignment;
use App\Models\AbstractReview;
use App\Models\AbstractCoAuthor;
use App\Models\SubTheme;
use App\Models\FullPaper;
use Illuminate\Support\Facades\DB;
use App\Models\ConferenceRegistration;
use App\Models\ExhibitionRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'totalSubmissions' => SubmittedAbstract::count(),
            'approvedCount'    => SubmittedAbstract::where('status', 'approved')->count(),
            'disapprovedCount' => SubmittedAbstract::where('status', 'rejected')->count(),
            'pendingCount'     => SubmittedAbstract::where('status', 'pending')->count(),
            'reviewCount'      => SubmittedAbstract::where('status', 'under_review')->count(),
            'fullPaperCount'   => FullPaper::count(),
            'registrationCount'  => ConferenceRegistration::count(),
            'exhibitionCount'    => ExhibitionRegistration::count(),
        ];

        // 🔹 Sub-theme distribution (REAL DATA)
        $subthemeStats = SubTheme::leftJoin(
                'submitted_abstracts',
                'sub_themes.id',
                '=',
                'submitted_abstracts.sub_theme_id'
            )
            ->select(
                'sub_themes.form_field_value',
                'sub_themes.full_name',
                DB::raw('COUNT(submitted_abstracts.id) as total')
            )
            ->groupBy(
                'sub_themes.id',
                'sub_themes.form_field_value',
                'sub_themes.full_name' // 👈 ADD THIS
            )
            ->orderBy('sub_themes.form_field_value')
            ->get();


        // Prepare chart arrays
        $chartData = [
            'subthemes'   => $subthemeStats->pluck('form_field_value'),
            'submissions' => $subthemeStats->pluck('total'),
            'full_names'   => $subthemeStats->pluck('full_name'),
        ];

        $recentAbstracts = SubmittedAbstract::latest()->limit(10)->get();

        return view('admin.dashboard2', compact(
            'metrics',
            'recentAbstracts',
            'chartData'
        ));
    }

    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'submissions');
        
        switch ($type) {
            case 'submissions':
                return $this->getSubmissionTrendData();
            case 'status':
                return $this->getStatusDistributionData();
            case 'subthemes':
                return $this->getSubthemeDistributionData();
            default:
                return response()->json([]);
        }
    }

    private function getSubmissionTrendData()
    {
        // Dummy data
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $count = rand(1, 5);
            $data[] = [
                'date' => $date,
                'count' => $count
            ];
        }

        return response()->json($data);
    }

    private function getStatusDistributionData()
    {
        $data = [
            ['status' => 'pending', 'count' => 12],
            ['status' => 'under_review', 'count' => 25],
            ['status' => 'approved', 'count' => 38],
            ['status' => 'rejected', 'count' => 12],
        ];

        return response()->json($data);
    }

    private function getSubthemeDistributionData()
    {
        $data = [
            ['name' => 'Climate-Smart Agriculture', 'count' => 28],
            ['name' => 'Sustainable Crop Production', 'count' => 22],
            ['name' => 'Livestock Innovation', 'count' => 19],
            ['name' => 'Agricultural Mechanization', 'count' => 18],
        ];

        return response()->json($data);
    }
}