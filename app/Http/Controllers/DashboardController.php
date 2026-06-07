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
use App\Models\GroupRegistration;
use App\Models\GroupMember;

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
            'resubmitCount'  => SubmittedAbstract::where('status', 'resubmit')->count(),
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

    public function financialSnapshot()
    {
        // ── Single / Individual (approved only) ──
        $singleKES   = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','KES')->sum('fee');
        $singleUSD   = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','USD')->sum('fee');
        $singleCount = ConferenceRegistration::where('payment_status','approved')->count();

        $singleFullWeekKES   = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','KES')
            ->where(fn($q) => $q->where('attendance_type','full_week')->orWhereNull('attendance_type'))->sum('fee');
        $singlePartialKES    = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','KES')
            ->where('attendance_type','partial')->sum('fee');
        $singleFullWeekCount = ConferenceRegistration::where('payment_status','approved')
            ->where(fn($q) => $q->where('attendance_type','full_week')->orWhereNull('attendance_type'))->count();
        $singlePartialCount  = ConferenceRegistration::where('payment_status','approved')->where('attendance_type','partial')->count();

        $partialByDays = ConferenceRegistration::where('payment_status','approved')->where('attendance_type','partial')
            ->selectRaw('days_count, COUNT(*) as registrants, SUM(fee) as collected')
            ->groupBy('days_count')->orderBy('days_count')->get();

        $singleVirtualKES  = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','KES')->where('platform','virtual')->sum('fee');
        $singleVirtualUSD  = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','USD')->where('platform','virtual')->sum('fee');
        $singlePhysicalKES = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','KES')->where('platform','physical')->sum('fee');
        $singlePhysicalUSD = ConferenceRegistration::where('payment_status','approved')->where('fee_currency','USD')->where('platform','physical')->sum('fee');

        // ── Group (approved only) ──
        $groupKES        = GroupRegistration::where('payment_status','approved')->where('currency','KES')->sum('total_fee');
        $groupUSD        = GroupRegistration::where('payment_status','approved')->where('currency','USD')->sum('total_fee');
        $groupCount      = GroupRegistration::where('payment_status','approved')->count();
        $groupMemberCount = GroupMember::whereHas('group', fn($q) => $q->where('payment_status','approved'))->count();

        // ── Exhibition (approved only) ──
        $exhibitionKES    = ExhibitionRegistration::where('status','approved')->sum('total_amount');
        $exhibitionCount  = ExhibitionRegistration::where('status','approved')->count();
        $exhibitionByType = ExhibitionRegistration::where('status','approved')
            ->selectRaw('registration_type, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('registration_type')->get();

        // ── Totals ──
        $grandTotalKES = $singleKES + $groupKES + $exhibitionKES;
        $grandTotalUSD = $singleUSD + $groupUSD;

        // ── Pending ──
        $pendingSingleKES     = ConferenceRegistration::where('payment_status','pending')->where('fee_currency','KES')->sum('fee');
        $pendingSingleUSD     = ConferenceRegistration::where('payment_status','pending')->where('fee_currency','USD')->sum('fee');
        $pendingGroupKES      = GroupRegistration::where('payment_status','pending')->where('currency','KES')->sum('total_fee');
        $pendingExhibitionKES = ExhibitionRegistration::where('status','pending')->sum('total_amount');

        // ── Recent (last 5 each) ──
        $recentSingle     = ConferenceRegistration::where('payment_status','approved')->latest('updated_at')->take(5)
            ->get(['first_name','last_name','fee','fee_currency','attendance_type','days_count','updated_at']);
        $recentGroup      = GroupRegistration::where('payment_status','approved')->latest('updated_at')->take(5)
            ->get(['first_name','last_name','total_fee','currency','updated_at']);
        $recentExhibition = ExhibitionRegistration::where('status','approved')->latest('approved_at')->take(5)
            ->get(['organization_name','total_amount','approved_at']);

        return view('admin.financial-snapshot', compact(
            'singleKES','singleUSD','singleCount',
            'singleFullWeekKES','singlePartialKES','singleFullWeekCount','singlePartialCount',
            'singleVirtualKES','singleVirtualUSD','singlePhysicalKES','singlePhysicalUSD',
            'partialByDays',
            'groupKES','groupUSD','groupCount','groupMemberCount',
            'exhibitionKES','exhibitionCount','exhibitionByType',
            'grandTotalKES','grandTotalUSD',
            'pendingSingleKES','pendingSingleUSD','pendingGroupKES','pendingExhibitionKES',
            'recentSingle','recentGroup','recentExhibition'
        ));
    }
}