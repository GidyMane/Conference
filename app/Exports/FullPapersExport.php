<?php

namespace App\Exports;

use App\Models\FullPaper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FullPapersExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = FullPaper::with([
            'submittedAbstract.subTheme',
            'reviewAssignments.prequalifiedReviewer',
            'reviewAssignments.peerReviewer',
            'reviewAssignments.fullPaperReview'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER: STATUS
        |--------------------------------------------------------------------------
        */
        if ($this->request->filled('status')) {
            $query->where('status', strtoupper($this->request->status));
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER: SUBTHEME
        |--------------------------------------------------------------------------
        */
        if ($this->request->filled('subtheme')) {
            $query->whereHas('submittedAbstract', function ($q) {
                $q->where('sub_theme_id', $this->request->subtheme);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER: DATE RANGE
        |--------------------------------------------------------------------------
        */
        if ($this->request->filled('date_range')) {
            switch ($this->request->date_range) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;

                case 'week':
                    $query->whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;

                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }
        }

        return $query->latest()->get()->map(function ($paper) {

            $prequalified = $paper->reviewAssignments
                ->whereNotNull('prequalified_reviewer_id')
                ->first();

            $peerAssignments = $paper->reviewAssignments
                ->whereNotNull('peer_reviewer_id')
                ->values();

            $peer1 = $peerAssignments->get(0);
            $peer2 = $peerAssignments->get(1);

            return [
                'full_paper_id'   => $paper->id,
                'abstract_id'     => $paper->submittedAbstract?->submission_code,
                'full_paper_code' => $paper->full_paper_code,
                'title'           => $paper->submittedAbstract?->paper_title,
                'subtheme'        => $paper->submittedAbstract?->subTheme?->form_field_value,
                'status'          => $paper->status,

                // Prequalified
                'prequalified_reviewer' => $prequalified?->prequalifiedReviewer?->name,
                'prequalified_email'    => $prequalified?->prequalifiedReviewer?->email,
                'prequalified_status'   => $prequalified?->fullPaperReview ? 'REVIEWED' : 'PENDING',

                // Peer 1
                'peer_reviewer_1' => $peer1?->peerReviewer?->full_name,
                'peer_email_1'    => $peer1?->peerReviewer?->email,
                'peer1_status'    => $peer1?->fullPaperReview ? 'REVIEWED' : 'PENDING',

                // Peer 2
                'peer_reviewer_2' => $peer2?->peerReviewer?->full_name,
                'peer_email_2'    => $peer2?->peerReviewer?->email,
                'peer2_status'    => $peer2?->fullPaperReview ? 'REVIEWED' : 'PENDING',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Full Paper ID',
            'Abstract ID',
            'Full Paper Code',
            'Title',
            'Subtheme',
            'Status',

            'Prequalified Reviewer',
            'Prequalified Email',
            'Prequalified Status',

            'Peer Reviewer 1',
            'Peer Email 1',
            'Peer 1 Status',

            'Peer Reviewer 2',
            'Peer Email 2',
            'Peer 2 Status',
        ];
    }
}