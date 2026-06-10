<?php

namespace App\Exports;

use App\Models\GroupRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GroupRegistrationsExport implements
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
        return 'Group Registrations';
    }

    public function collection()
    {
        $query = GroupRegistration::with('members');

        if (!empty($this->filters['payment_status'])) {
            $query->where('payment_status', $this->filters['payment_status']);
        }

        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%{$s}%")
                  ->orWhere('last_name',  'like', "%{$s}%")
                  ->orWhere('email',      'like', "%{$s}%");
            });
        }

        $rows = collect();

        foreach ($query->orderBy('created_at', 'desc')->get() as $group) {
            // One coordinator row
            $rows->push([
                'Row Type'            => 'Coordinator',
                'Group ID'            => $group->id,
                'First Name'          => $group->first_name,
                'Last Name'           => $group->last_name,
                'Email'               => $group->email,
                'Phone'               => ($group->phone_prefix ?? '') . ' ' . ($group->phone_number ?? ''),
                'Institution'         => $group->institution,
                'Nationality'         => '—',
                'Platform'            => '—',
                'Category'            => '—',
                'Presenter'           => '—',
                'Paper Ref Code'      => '—',
                'Member Fee'          => '—',
                'Member Currency'     => '—',
                'Group Count'         => $group->group_count,
                'Total Group Fee'     => $group->total_fee,
                'Currency'            => $group->currency,
                'Transaction ID'      => $group->transaction_id ?? '—',
                'Payment Status'      => ucfirst($group->payment_status ?? ''),
                'Rejection Reason'    => $group->rejection_reason ?? '—',
                'Registered On'       => $group->created_at ? $group->created_at->format('Y-m-d H:i') : '—',
            ]);

            // One row per member
            foreach ($group->members as $member) {
                $rows->push([
                    'Row Type'            => 'Member',
                    'Group ID'            => $group->id,
                    'First Name'          => $member->first_name,
                    'Last Name'           => $member->last_name,
                    'Email'               => $member->email,
                    'Phone'               => '—',
                    'Institution'         => $member->institution ?? '—',
                    'Nationality'         => ucfirst(str_replace('_', ' ', $member->nationality ?? '')),
                    'Platform'            => ucfirst($member->platform ?? ''),
                    'Category'            => ucfirst(str_replace('_', ' ', $member->category ?? '')),
                    'Presenter'           => ucfirst($member->presenter ?? ''),
                    'Paper Ref Code'      => $member->paper_ref_code ?? '—',
                    'Member Fee'          => $member->fee ?? '—',
                    'Member Currency'     => $member->currency ?? '—',
                    'Group Count'         => '—',
                    'Total Group Fee'     => '—',
                    'Currency'            => '—',
                    'Transaction ID'      => '—',
                    'Payment Status'      => ucfirst($member->payment_status ?? ''),
                    'Rejection Reason'    => '—',
                    'Registered On'       => '—',
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Row Type', 'Group ID', 'First Name', 'Last Name', 'Email', 'Phone',
            'Institution', 'Nationality', 'Platform', 'Category',
            'Presenter', 'Paper Ref Code', 'Member Fee', 'Member Currency',
            'Group Count', 'Total Group Fee', 'Currency',
            'Transaction ID', 'Payment Status', 'Rejection Reason', 'Registered On',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '1E3A8A']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14, 'B' => 10, 'C' => 16, 'D' => 16, 'E' => 26, 'F' => 18,
            'G' => 26, 'H' => 18, 'I' => 12, 'J' => 16, 'K' => 12, 'L' => 16,
            'M' => 12, 'N' => 12, 'O' => 14, 'P' => 16, 'Q' => 12,
            'R' => 20, 'S' => 16, 'T' => 26, 'U' => 20,
        ];
    }
}
