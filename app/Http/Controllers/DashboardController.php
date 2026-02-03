<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // DUMMY DATA - Replace with actual database queries
        $metrics = [
            'total_abstracts' => 87,
            'pending_abstracts' => 12,
            'under_review_abstracts' => 25,
            'approved_abstracts' => 38,
            'rejected_abstracts' => 12,
            
            'total_full_papers' => 35,
            'submitted_papers' => 8,
            'accepted_papers' => 27,
            
            'total_reviewers' => 12,
            'active_reviewers' => 10,
            
            'total_registrations' => 156,
            'total_exhibitions' => 23,
            
            'abstracts_this_month' => 45,
            'abstracts_today' => 3,
            'pending_assignments' => 15,
            'completed_reviews' => 62,
        ];
        
        // Dummy recent abstracts
        $recentAbstracts = [
            (object)[
                'id' => 1,
                'submission_id' => 'SUB01-087',
                'title' => 'Climate-Resilient Maize Varieties for Semi-Arid Regions',
                'status' => 'pending',
                'created_at' => new \DateTime('2026-02-03 10:30:00'),
                'subTheme' => (object)['name' => 'Climate-Smart Agriculture'],
                'correspondingAuthor' => (object)['full_name' => 'Dr. Jane Mwangi']
            ],
            (object)[
                'id' => 2,
                'submission_id' => 'SUB02-045',
                'title' => 'Integrated Pest Management in Horticultural Crops',
                'status' => 'under_review',
                'created_at' => new \DateTime('2026-02-02 14:15:00'),
                'subTheme' => (object)['name' => 'Sustainable Crop Production'],
                'correspondingAuthor' => (object)['full_name' => 'Prof. Samuel Ochieng']
            ],
            (object)[
                'id' => 3,
                'submission_id' => 'SUB03-032',
                'title' => 'Improving Dairy Cattle Productivity Through Nutrition',
                'status' => 'approved',
                'created_at' => new \DateTime('2026-02-01 09:00:00'),
                'subTheme' => (object)['name' => 'Livestock Innovation'],
                'correspondingAuthor' => (object)['full_name' => 'Dr. Ruth Wambui']
            ],
            (object)[
                'id' => 4,
                'submission_id' => 'SUB01-086',
                'title' => 'Water Harvesting Technologies for Small-Scale Farmers',
                'status' => 'approved',
                'created_at' => new \DateTime('2026-01-31 16:45:00'),
                'subTheme' => (object)['name' => 'Climate-Smart Agriculture'],
                'correspondingAuthor' => (object)['full_name' => 'Eng. Peter Kamau']
            ],
            (object)[
                'id' => 5,
                'submission_id' => 'SUB04-028',
                'title' => 'Precision Agriculture: GPS-Guided Tractors in Kenya',
                'status' => 'under_review',
                'created_at' => new \DateTime('2026-01-30 11:20:00'),
                'subTheme' => (object)['name' => 'Agricultural Mechanization'],
                'correspondingAuthor' => (object)['full_name' => 'Dr. Michael Njoroge']
            ],
        ];
        
        // Dummy recent reviews
        $recentReviews = [
            (object)[
                'title' => 'Improving Dairy Cattle Productivity Through Nutrition',
                'reviewer_name' => 'Dr. Peter Omondi',
                'decision' => 'approved',
                'overall_score' => 4.5,
                'created_at' => '2026-02-02 15:30:00'
            ],
            (object)[
                'title' => 'Integrated Pest Management in Horticultural Crops',
                'reviewer_name' => 'Prof. Mary Wanjiru',
                'decision' => 'approved',
                'overall_score' => 4.2,
                'created_at' => '2026-02-02 11:15:00'
            ],
            (object)[
                'title' => 'Sustainable Soil Management Practices',
                'reviewer_name' => 'Dr. John Kamau',
                'decision' => 'needs_revision',
                'overall_score' => 3.8,
                'created_at' => '2026-02-01 16:45:00'
            ],
            (object)[
                'title' => 'Indigenous Vegetable Production Systems',
                'reviewer_name' => 'Dr. Sarah Muthoni',
                'decision' => 'approved',
                'overall_score' => 4.7,
                'created_at' => '2026-02-01 10:20:00'
            ],
            (object)[
                'title' => 'Post-Harvest Loss Reduction Strategies',
                'reviewer_name' => 'Prof. David Njoroge',
                'decision' => 'rejected',
                'overall_score' => 2.5,
                'created_at' => '2026-01-31 14:00:00'
            ],
        ];

        // Abstract status distribution
        $abstractStatusDistribution = [
            'pending' => 12,
            'under_review' => 25,
            'approved' => 38,
            'rejected' => 12,
        ];

        // Submission trend (last 30 days)
        $submissionTrend = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $count = rand(1, 5); // Random count for demo
            $submissionTrend[] = (object)[
                'date' => $date,
                'count' => $count
            ];
        }

        return view('admin.dashboard.index', compact(
            'metrics',
            'recentAbstracts',
            'recentReviews',
            'abstractStatusDistribution',
            'submissionTrend'
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