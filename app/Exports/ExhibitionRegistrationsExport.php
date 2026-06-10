<?php

namespace App\Exports;

use App\Models\ExhibitionRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExhibitionRegistrationsExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Exhibition Registrations';
    }

    public function collection()
    {
        $query = ExhibitionRegistration::query();

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['registration_type'])) {
            $query->where('registration_type', $this->filters['registration_type']);
        }

        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('organization_name', 'like', "%{$s}%")
                  ->orWhere('contact_name',     'like', "%{$s}%")
                  ->orWhere('contact_email',    'like', "%{$s}%")
                  ->orWhere('reference_number', 'like', "%{$s}%");
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($e) => [
                'Reference No.'       => $e->reference_number ?? '—',
                'Organization Name'   => $e->organization_name,
                'About Exhibition'    => $e->about_exhibition ?? '—',
                'Benefits'            => $e->benefits ?? '—',
                'Registration Type'   => ucfirst(str_replace('_', ' ', $e->registration_type ?? '')),
                'Target Audience'     => $e->target_audience ?? '—',
                'Booth Count'         => $e->booth_count ?? 1,
                'Booth Number'        => $e->booth_number ?? '—',
                'Total Amount (KES)'  => $e->total_amount,
                'Payment Method'      => ucfirst($e->payment_method ?? ''),
                'Receipt Number'      => $e->receipt_number ?? '—',
                'Payment Status'      => ucfirst($e->payment_status ?? ''),
                'Contact Name'        => $e->contact_name ?? '—',
                'Contact Role'        => $e->contact_role ?? '—',
                'Contact Phone'       => $e->contact_phone ?? '—',
                'Contact Email'       => $e->contact_email ?? '—',
                'Is Team Leader'      => $e->is_team_leader ? 'Yes' : 'No',
                'Team Size'           => $e->team_size ?? '—',
                'Status'              => ucfirst($e->status ?? ''),
                'Special Requests'    => $e->special_requests ?? '—',
                'Admin Notes'         => $e->admin_notes ?? '—',
                'Approved At'         => $e->approved_at ? \Carbon\Carbon::parse($e->approved_at)->format('Y-m-d H:i') : '—',
                'Registered On'       => $e->created_at ? $e->created_at->format('Y-m-d H:i') : '—',
            ]);
    }

    public function headings(): array
    {
        return [
            'Reference No.', 'Organization Name', 'About Exhibition', 'Benefits',
            'Registration Type', 'Target Audience', 'Booth Count', 'Booth Number',
            'Total Amount (KES)', 'Payment Method', 'Receipt Number', 'Payment Status',
            'Contact Name', 'Contact Role', 'Contact Phone', 'Contact Email',
            'Is Team Leader', 'Team Size', 'Status', 'Special Requests',
            'Admin Notes', 'Approved At', 'Registered On',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '6B21A8']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16, 'B' => 28, 'C' => 30, 'D' => 26,
            'E' => 18, 'F' => 20, 'G' => 13, 'H' => 14,
            'I' => 18, 'J' => 16, 'K' => 16, 'L' => 16,
            'M' => 20, 'N' => 18, 'O' => 16, 'P' => 26,
            'Q' => 14, 'R' => 12, 'S' => 14, 'T' => 26,
            'U' => 26, 'V' => 20, 'W' => 20,
        ];
    }
}
