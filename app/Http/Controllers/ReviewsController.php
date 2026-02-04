<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReviewsController extends Controller
{
    /**
     * Show pending reviews
     */
    public function pendingReviews(Request $request)
    {
        $data = [
            (object)[
                'id' => 1,
                'status' => 'assigned',
                'assigned_at' => now()->subDays(2),
                'deadline' => now()->addDays(5),
                'abstract' => (object)[
                    'id' => 101,
                    'submission_code' => 'AB-001',
                    'paper_title' => 'AI in Agriculture',
                    'author_name' => 'John Doe',
                    'author_email' => 'john@example.com',
                    'organisation' => 'AgriTech Inc.',
                    'subTheme' => (object)['name' => 'Technology in Farming'],
                    'abstract_text' => 'This study explores the use of AI in modern agriculture...',
                    'keywords' => 'AI, Agriculture, Technology',
                    'uploaded_file' => null,
                ],
            ],
            (object)[
                'id' => 2,
                'status' => 'under_review',
                'assigned_at' => now()->subDays(5),
                'deadline' => now()->addDays(2),
                'abstract' => (object)[
                    'id' => 102,
                    'submission_code' => 'AB-002',
                    'paper_title' => 'Climate Change Effects',
                    'author_name' => 'Jane Smith',
                    'author_email' => 'jane@example.com',
                    'organisation' => 'EnviroGroup',
                    'subTheme' => (object)['name' => 'Environmental Studies'],
                    'abstract_text' => 'An analysis of the effects of climate change on crop yields...',
                    'keywords' => 'Climate Change, Agriculture, Environment',
                    'uploaded_file' => null,
                ],
            ],
        ];

        $page = $request->get('page', 1);
        $perPage = 15;
        $collection = collect($data);
        $pendingReviews = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $stats = [
            'pending' => 1,
            'under_review' => 1,
        ];

        return view('reviewer.pending-reviews', compact('pendingReviews', 'stats'));
    }

    /**
     * Show completed reviews
     */
    public function completedReviews(Request $request)
    {
        $data = [
            (object)[
                'id' => 201,
                'decision' => 'APPROVED',
                'relevance_score' => 5,
                'methodology_score' => 4,
                'originality_score' => 4,
                'clarity_score' => 5,
                'overall_score' => 4.5,
                'comments' => 'Excellent work with clear methodology.',
                'created_at' => now()->subDays(3),
                'abstract' => (object)[
                    'id' => 201,
                    'submission_code' => 'AB-010',
                    'paper_title' => 'Renewable Energy',
                    'author_name' => 'Alice Johnson',
                    'author_email' => 'alice@example.com',
                    'organisation' => 'GreenPower Ltd.',
                    'subTheme' => (object)['name' => 'Sustainable Tech'],
                    'abstract_text' => 'Exploring renewable energy sources in urban areas...',
                    'keywords' => 'Renewable, Energy, Sustainability',
                    'uploaded_file' => null,
                ],
            ],
            (object)[
                'id' => 202,
                'decision' => 'NEEDS_REVISION',
                'relevance_score' => 3,
                'methodology_score' => 3,
                'originality_score' => 4,
                'clarity_score' => 3,
                'overall_score' => 3.3,
                'comments' => 'Good concept but needs better clarity in results section.',
                'created_at' => now()->subDays(1),
                'abstract' => (object)[
                    'id' => 202,
                    'submission_code' => 'AB-011',
                    'paper_title' => 'Soil Health',
                    'author_name' => 'Bob Williams',
                    'author_email' => 'bob@example.com',
                    'organisation' => 'AgroResearch',
                    'subTheme' => (object)['name' => 'Agronomy'],
                    'abstract_text' => 'Studying the impact of fertilizers on soil health...',
                    'keywords' => 'Soil, Fertilizer, Agriculture',
                    'uploaded_file' => null,
                ],
            ],
        ];

        $page = $request->get('page', 1);
        $perPage = 15;
        $collection = collect($data);
        $completedReviews = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $stats = [
            'approved' => 1,
            'rejected' => 0,
            'needs_revision' => 1,
        ];

        return view('reviewer.completed-reviews', compact('completedReviews', 'stats'));
    }

    /**
     * Dummy submit review
     */
    public function submitReview(Request $request)
    {
        return redirect()
            ->route('reviewer.pending-reviews')
            ->with('success', 'Dummy review submitted successfully!');
    }

    /**
     * Dummy start review (AJAX)
     */
    public function startReview($assignmentId)
    {
        return response()->json([
            'success' => true,
            'message' => "Dummy review for assignment ID {$assignmentId} started",
        ]);
    }
}
