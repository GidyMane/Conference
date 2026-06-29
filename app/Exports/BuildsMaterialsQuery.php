<?php

namespace App\Exports;

use App\Models\FullPaper;

/**
 * Shared base query for the materials-submission report sheets.
 * Keeps both sheets consistent with the filters used on the
 * "Fully Reviewed Papers" admin screen.
 */
trait BuildsMaterialsQuery
{
    protected function baseQuery()
    {
        $approvedStatuses = ['approved', 'APPROVED'];

        $query = FullPaper::with([
                'abstract',
                'abstract.subTheme',
                'abstract.coAuthors',
                'presentationUpload',
            ])
            ->whereIn('status', $approvedStatuses);

        if (!empty($this->search)) {
            $search = $this->search;
            $query->whereHas('abstract', function ($q) use ($search) {
                $q->where('paper_title', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('submission_code', 'like', "%{$search}%");
            });
        }

        if (!empty($this->subthemeFilter)) {
            $subthemeFilter = $this->subthemeFilter;
            $query->whereHas('abstract.subTheme', function ($q) use ($subthemeFilter) {
                $q->where('id', $subthemeFilter);
            });
        }

        return $query;
    }

    /**
     * Maps a FullPaper into the flat row array used by both sheets.
     */
    protected function mapRow(FullPaper $paper): array
    {
        $abstract = $paper->abstract;
        $upload   = $paper->presentationUpload;

        $coAuthors = $abstract && $abstract->coAuthors
            ? $abstract->coAuthors->pluck('full_name')->filter()->implode('; ')
            : '';

        return [
            'submission_code'   => $abstract?->submission_code,
            'title'             => $abstract?->paper_title,
            'author_name'       => $abstract?->author_name,
            'author_email'      => $abstract?->author_email,
            'author_phone'      => $abstract?->author_phone,
            'organisation'      => $abstract?->organisation,
            'co_authors'        => $coAuthors,
            'subtheme'          => $abstract?->subTheme?->full_name,
            'status'            => $paper->status,
            'revised_paper'     => $upload && $upload->revised_fullpaper ? 'Yes' : 'No',
            'powerpoint'        => $upload && $upload->powerpoint_file ? 'Yes' : 'No',
            'poster'            => $upload && $upload->poster_file ? 'Yes' : 'No',
            'supporting_docs'   => $upload && !empty($upload->supporting_documents) ? 'Yes' : 'No',
            'uploaded_at'       => $upload && $upload->uploaded_at
                ? \Illuminate\Support\Carbon::parse($upload->uploaded_at)->format('M d, Y H:i')
                : '',
            'decision_date'     => $paper->updated_at ? $paper->updated_at->format('M d, Y') : '',
        ];
    }

    protected function headingsList(): array
    {
        return [
            'Submission Code',
            'Paper Title',
            'Author Name',
            'Author Email',
            'Author Phone',
            'Institution / Organisation',
            'Co-Authors',
            'Sub-Theme',
            'Status',
            'Revised Paper Uploaded',
            'PowerPoint Uploaded',
            'Poster Uploaded',
            'Supporting Docs Uploaded',
            'Materials Uploaded On',
            'Decision Date',
        ];
    }
}
