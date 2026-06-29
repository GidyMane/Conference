<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialsMissingSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    use BuildsMaterialsQuery;

    protected $search;
    protected $subthemeFilter;

    public function __construct($search = '', $subthemeFilter = '')
    {
        $this->search         = $search;
        $this->subthemeFilter = $subthemeFilter;
    }

    public function collection()
    {
        $papers = $this->baseQuery()
            ->where(function ($q) {
                $q->whereDoesntHave('presentationUpload')
                  ->orWhereHas('presentationUpload', function ($q2) {
                      $q2->whereNull('revised_fullpaper')
                         ->whereNull('powerpoint_file')
                         ->whereNull('poster_file');
                  });
            })
            ->latest('updated_at')
            ->get();

        return $papers->map(fn ($paper) => $this->mapRow($paper));
    }

    public function headings(): array
    {
        return $this->headingsList();
    }

    public function title(): string
    {
        return 'Not Submitted';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'DC2626']]],
        ];
    }
}
