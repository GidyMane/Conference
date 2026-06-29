<?php

namespace App\Exports;

use App\Models\FullPaper;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

/**
 * MaterialsSubmissionExport
 * --------------------------------------------------------------------
 * Produces a two-sheet Excel workbook for approved Full Papers:
 *
 *   Sheet 1 — "Submitted Materials"      papers that HAVE uploaded
 *                                        a revised paper, PPT, or poster
 *   Sheet 2 — "Not Submitted"            approved papers with NO
 *                                        materials uploaded yet
 *
 * Respects the same optional filters used on the admin
 * "Fully Reviewed Papers" screen (status is always restricted to
 * approved here since materials tracking only applies to approved
 * papers): search, subtheme.
 */
class MaterialsSubmissionExport implements WithMultipleSheets
{
    protected $search;
    protected $subthemeFilter;

    public function __construct($search = '', $subthemeFilter = '')
    {
        $this->search         = $search;
        $this->subthemeFilter = $subthemeFilter;
    }

    public function sheets(): array
    {
        return [
            'Submitted Materials' => new MaterialsSubmittedSheet($this->search, $this->subthemeFilter),
            'Not Submitted'       => new MaterialsMissingSheet($this->search, $this->subthemeFilter),
        ];
    }
}
