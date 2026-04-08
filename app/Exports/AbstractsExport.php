<?php

namespace App\Exports;

use App\Models\SubmittedAbstract;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbstractsExport implements FromCollection, WithHeadings
{
    protected $user;
    protected $filters;

    public function __construct($user, $filters = [])
    {
        $this->user = $user;
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

        // 🔐 Role filtering (same logic as your controller)
        if ($this->user->role === 'REVIEWER') {
            $query->whereHas('assignments', function ($q) {
                $q->where('reviewer_id', $this->user->id);
            });
        }

        if ($this->user->role === 'TEMP_REVIEWER') {
            $query->where('sub_theme_id', optional($this->user->tempReviewer)->sub_theme_id);
        }

        // 🎯 Apply filters (status, sort, etc)
        if (!empty($this->filters['status'])) {
            $query->where('status', strtoupper($this->filters['status']));
        }

        return $query->get()->map(function ($a) {

            return [
                'Submission Code' => $a->submission_code,
                'Title' => $a->paper_title,

                // Author Info
                'Author Name' => $a->author_name,
                'Email' => $a->author_email,
                'Phone' => $a->author_phone,
                'Organisation' => $a->organisation,
                'Department' => $a->department,
                'Position' => $a->position,

                // Theme
                'Sub Theme' => $a->subTheme->full_name ?? '',

                // Content
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
                'Assigned Date' => optional($a->assignments->first())->created_at,

                // Dates
                'Submitted At' => $a->created_at,

                // Co-authors (🔥 important)
                'Co Authors' => $a->coAuthors->map(function ($c) {
                    return $c->full_name . ' (' . $c->institution . ')';
                })->implode(', '),
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
            'Assigned Date',
            'Submitted At',
            'Co Authors'
        ];
    }
}