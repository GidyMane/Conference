<?php

namespace App\Exports;

use App\Models\ConferenceRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ConferenceRegistrationsExport implements
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
        return 'Individual Registrations';
    }

    public function collection()
    {
        $query = ConferenceRegistration::query();

        if (!empty($this->filters['payment_status'])) {
            $query->where('payment_status', $this->filters['payment_status']);
        }

        if (!empty($this->filters['platform'])) {
            $query->where('platform', $this->filters['platform']);
        }

        if (!empty($this->filters['attendance_type'])) {
            if ($this->filters['attendance_type'] === 'full_week') {
                $query->where(function ($q) {
                    $q->where('attendance_type', 'full_week')->orWhereNull('attendance_type');
                });
            } else {
                $query->where('attendance_type', $this->filters['attendance_type']);
            }
        }

        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%{$s}%")
                  ->orWhere('last_name',  'like', "%{$s}%")
                  ->orWhere('email',      'like', "%{$s}%");
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($r) => [
                'Ticket No.'      => $r->ticket_number ?? '—',
                'First Name'      => $r->first_name,
                'Last Name'       => $r->last_name,
                'Email'           => $r->email,
                'Phone'           => ($r->phone_prefix ?? '') . ' ' . ($r->phone_number ?? ''),
                'Institution'     => $r->institution,
                'Country'         => $r->country,
                'Nationality'     => ucfirst(str_replace('_', ' ', $r->nationality ?? '')),
                'Platform'        => ucfirst($r->platform ?? ''),
                'Category'        => ucfirst(str_replace('_', ' ', $r->category ?? '')),
                'Attendance Type' => ($r->attendance_type === 'partial') ? 'Partial Days' : 'Full Week',
                'Days Count'      => $r->days_count ?? '—',
                'Paper Ref Code'  => $r->paper_ref_code ?? '—',
                'Fee'             => $r->fee,
                'Currency'        => $r->fee_currency,
                'Payment Method'  => ucfirst($r->payment_method ?? ''),
                'Transaction ID'  => $r->transaction_id ?? '—',
                'Payment Status'  => ucfirst($r->payment_status ?? ''),
                'Rejection Reason'=> $r->rejection_reason ?? '—',
                'Registered On'   => $r->created_at ? $r->created_at->format('Y-m-d H:i') : '—',
                'Verified At'     => $r->verified_at ? \Carbon\Carbon::parse($r->verified_at)->format('Y-m-d H:i') : '—',
            ]);
    }

    public function headings(): array
    {
        return [
            'Ticket No.', 'First Name', 'Last Name', 'Email', 'Phone',
            'Institution', 'Country', 'Nationality', 'Platform', 'Category',
            'Attendance Type', 'Days Count', 'Paper Ref Code',
            'Fee', 'Currency', 'Payment Method', 'Transaction ID',
            'Payment Status', 'Rejection Reason', 'Registered On', 'Verified At',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '166534']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14, 'B' => 16, 'C' => 16, 'D' => 26, 'E' => 18,
            'F' => 26, 'G' => 16, 'H' => 18, 'I' => 12, 'J' => 16,
            'K' => 18, 'L' => 12, 'M' => 16, 'N' => 10, 'O' => 10,
            'P' => 16, 'Q' => 20, 'R' => 16, 'S' => 26, 'T' => 20, 'U' => 20,
        ];
    }
}
