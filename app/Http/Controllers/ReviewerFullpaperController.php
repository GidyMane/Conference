<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ReviewerFullpaperController extends Controller
{
    /**
     * Display full papers for abstracts the reviewer approved (dummy data)
     */
    public function index(Request $request)
    {
        // Dummy full papers data
        $data = [
            (object)[
                'id' => 1,
                'submitted_abstract_id' => 'AB-001',
                'status' => 'pending',
                'paper_file_path' => 'dummy/paper1.pdf',
                'presentation_file_path' => 'dummy/ppt1.pptx',
                'supplementary_files_path' => json_encode(['dummy/supp1.docx']),
                'created_at' => now()->subDays(2),
                'abstract' => (object)[
                    'submission_code' => 'AB-001',
                    'paper_title' => 'AI in Agriculture',
                    'author_name' => 'John Doe',
                    'author_email' => 'john@example.com',
                    'subTheme' => (object)['name' => 'Technology in Farming'],
                ],
            ],
            (object)[
                'id' => 2,
                'submitted_abstract_id' => 'AB-002',
                'status' => 'accepted',
                'paper_file_path' => 'dummy/paper2.pdf',
                'presentation_file_path' => null,
                'supplementary_files_path' => null,
                'created_at' => now()->subDays(5),
                'abstract' => (object)[
                    'submission_code' => 'AB-002',
                    'paper_title' => 'Climate Change Effects',
                    'author_name' => 'Jane Smith',
                    'author_email' => 'jane@example.com',
                    'subTheme' => (object)['name' => 'Environmental Studies'],
                ],
            ],
            (object)[
                'id' => 3,
                'submitted_abstract_id' => 'AB-003',
                'status' => 'pending',
                'paper_file_path' => null,
                'presentation_file_path' => null,
                'supplementary_files_path' => null,
                'created_at' => now()->subDays(1),
                'abstract' => (object)[
                    'submission_code' => 'AB-003',
                    'paper_title' => 'Soil Health Analysis',
                    'author_name' => 'Bob Williams',
                    'author_email' => 'bob@example.com',
                    'subTheme' => (object)['name' => 'Agronomy'],
                ],
            ],
        ];

        // Pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $collection = collect($data);
        $fullPapers = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Stats
        $stats = [
            'total' => count($data),
            'pending' => count(array_filter($data, fn($p) => $p->status === 'pending')),
            'approved' => count(array_filter($data, fn($p) => $p->status === 'accepted')),
        ];

        return view('reviewer.fullpapers', compact('fullPapers', 'stats'));
    }

    /**
     * Show details of a specific full paper (dummy)
     */
    public function show($id)
    {
        $paper = (object)[
            'id' => $id,
            'submitted_abstract_id' => 'AB-001',
            'status' => 'pending',
            'paper_file_path' => 'dummy/paper1.pdf',
            'presentation_file_path' => 'dummy/ppt1.pptx',
            'supplementary_files_path' => json_encode(['dummy/supp1.docx']),
            'created_at' => now()->subDays(2),
            'abstract' => (object)[
                'submission_code' => 'AB-001',
                'paper_title' => 'AI in Agriculture',
                'author_name' => 'John Doe',
                'author_email' => 'john@example.com',
                'subTheme' => (object)['name' => 'Technology in Farming'],
            ],
        ];

        return view('reviewer.fullpapers.show', compact('paper'));
    }
}
