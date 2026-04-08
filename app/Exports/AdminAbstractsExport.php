<?php

namespace App\Exports;

use App\Models\SubmittedAbstract;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminAbstractsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = SubmittedAbstract::with([
            'subTheme',
            'latestReview',
            'assignments',
            'coAuthors'
        ]);

        // 🔎 FILTER: Sub-theme
        if (!empty($this->filters['sub_theme'])) {
            $query->where('sub_theme_id', $this->filters['sub_theme']);
        }

        // 🔎 FILTER: Status
        if (!empty($this->filters['status'])) {
            $query->where('status', strtoupper($this->filters['status']));
        }

        // 🔎 FILTER: Date Range
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($a) {

                return [
                    'Submission Code' => $a->submission_code,
                    'Title' => $a->paper_title,

                    // Author
                    'Author Name' => $a->author_name,
                    'Email' => $a->author_email,
                    'Phone' => $a->author_phone,
                    'Organisation' => $a->organisation,
                    'Department' => $a->department,
                    'Position' => $a->position,

                    // Theme
                    'Sub Theme' => $a->subTheme->full_name ?? '',

                    // Abstract Content
                    'Abstract' => $a->abstract_text,
                    'Keywords' => $a->keywords,

                    // Preferences
                    'Presentation Type' => $a->presentation_preference,
                    'Attendance Mode' => $a->attendance_mode,

                    // Extra
                    'Special Requirements' => $a->special_requirements,

                    // Status
                    'Status' => $a->status,

                    // Review Info
                    'Reviewer Comment' => $a->latestReview->comment ?? '',
                    'Reviewer Decision' => $a->latestReview->decision ?? '',

                    // Assignment Info
                    'Assigned Reviewer ID' => optional($a->assignments->first())->reviewer_id,
                    'Assigned Date' => optional($a->assignments->first())->created_at,

                    // Dates
                    'Submitted At' => $a->created_at,
                    'Last Updated' => $a->updated_at,

                    // Co-authors
                    'Co Authors' => $a->coAuthors
                        ->map(fn($c) => $c->full_name . ' (' . $c->institution . ')')
                        ->implode(', '),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Submission Code',
            'Title',
            'Author Name',
            'Email',
            'Phone',
            'Organisation',
            'Department',
            'Position',
            'Sub Theme',
            'Abstract',
            'Keywords',
            'Presentation Type',
            'Attendance Mode',
            'Special Requirements',
            'Status',
            'Reviewer Comment',
            'Reviewer Decision',
            'Assigned Reviewer ID',
            'Assigned Date',
            'Submitted At',
            'Last Updated',
            'Co Authors'
        ];
    }
}
