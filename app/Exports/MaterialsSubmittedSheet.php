<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MaterialsSubmittedSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
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
            ->whereHas('presentationUpload', function ($q) {
                $q->where(function ($q2) {
                    $q2->whereNotNull('revised_fullpaper')
                       ->orWhereNotNull('powerpoint_file')
                       ->orWhereNotNull('poster_file');
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
        return 'Submitted Materials';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                  'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2D8A3E']]],
        ];
    }
}
