<?php

namespace App\Exports;

use App\Models\HrStep;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class FlightReportExport implements FromCollection, WithHeadings, WithDrawings, WithEvents, WithStyles, WithStartRow
{
    protected $flightDate;

    public function __construct($flightDate = null)
    {
        $this->flightDate = $flightDate;
    }

    public function collection()
    {
        $query = HrStep::with(['humanResource.crafts'])->where('step_number', 6);

        if ($this->flightDate) {
            $query->where('flight_date', $this->flightDate);
        }

        return $query->get()->map(function ($row, $index) {
            return [
                $index + 1,
                '', // spacing
                $row->humanResource->name ?? 'N/A',
                '', // spacing
                $row->humanResource->crafts->name ?? 'N/A',
                '', // spacing
                $row->humanResource->passport ?? 'N/A',
                '', // spacing
                $row->flight_route ?? 'N/A',
                '', // spacing
                $row->flight_date ?? 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr.',
            '',
            'Name',
            '',
            'Approved For Craft',
            '',
            'Passport',
            '',
            'Flight Route',
            '',
            'Flight Date'
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Company Logo');
        $drawing->setPath(public_path('/admin/assets/images/mansol-01.png'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('E1'); // Logo on top, not inside table
        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                // Insert 8 blank rows at the top
                $event->sheet->insertNewRowBefore(1, 8);

                // Title below logo, row 6 or 7
                $event->sheet->setCellValue('E6', 'Flight Report');
                $event->sheet->mergeCells('E6:I6');
                $event->sheet->getStyle('E6')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('E6')->getAlignment()->setHorizontal('center');
            },
        ];
    }

    public function startRow(): int
    {
        return 10; // Headings will be on row 9, data starts from row 10
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A9:K9')->getFont()->setBold(true)->setSize(12); // Heading row 9
        $sheet->getRowDimension(9)->setRowHeight(22);

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
