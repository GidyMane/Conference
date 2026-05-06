<?php
namespace App\Exports;

use App\Models\FullPaper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaderFullPapersExport implements FromCollection, WithHeadings
{
    protected $subThemeIds;
    protected $status;

    public function __construct($subThemeIds, $status = null)
    {
        $this->subThemeIds = $subThemeIds;
        $this->status = $status;
    }

    public function collection()
{
    $query = FullPaper::with([
        'abstract.subTheme',
        'reviewAssignments.prequalifiedReviewer',
        'reviewAssignments.peerReviewer',
        'reviewAssignments.fullPaperReview'
    ])
    ->whereHas('abstract', function ($q) {
        $q->whereIn('sub_theme_id', $this->subThemeIds);
    });

    if ($this->status) {
        $query->where('status', $this->status);
    }

    return $query->get()->map(function ($paper) {

        // PREQUALIFIED ASSIGNMENT
        $prequalified = $paper->reviewAssignments
            ->whereNotNull('prequalified_reviewer_id')
            ->first();

        // PEER ASSIGNMENTS
        $peerAssignments = $paper->reviewAssignments
            ->whereNotNull('peer_reviewer_id')
            ->values();

        $peer1 = $peerAssignments->get(0);
        $peer2 = $peerAssignments->get(1);

        return [
            // =========================
            // BASIC PAPER INFO
            // =========================
            'paper_id'      => $paper->id,
            'title'         => $paper->abstract->paper_title ?? '',
            'subtheme'      => $paper->abstract->subTheme->form_field_value ?? '',
            'status'        => $paper->status,
            'full_paper_code' => $paper->full_paper_code ?? null,

            // =========================
            // PREQUALIFIED REVIEWER
            // =========================
            'prequalified_reviewer' => $prequalified?->prequalifiedReviewer?->name,
            'prequalified_email'    => $prequalified?->prequalifiedReviewer?->email,
            'prequalified_status'   => $prequalified?->fullPaperReview ? 'REVIEWED' : 'PENDING',

            // =========================
            // PEER REVIEWER 1
            // =========================
            'peer_reviewer_1' => $peer1?->peerReviewer?->full_name,
            'peer_email_1'    => $peer1?->peerReviewer?->email,
            'peer_1_status'   => $peer1?->fullPaperReview ? 'REVIEWED' : 'PENDING',

            // =========================
            // PEER REVIEWER 2
            // =========================
            'peer_reviewer_2' => $peer2?->peerReviewer?->full_name,
            'peer_email_2'    => $peer2?->peerReviewer?->email,
            'peer_2_status'   => $peer2?->fullPaperReview ? 'REVIEWED' : 'PENDING',
        ];
    });
}

    public function headings(): array
{
    return [
        'Paper ID',
        'Title',
        'Subtheme',
        'Status',
        'Full Paper Code',

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