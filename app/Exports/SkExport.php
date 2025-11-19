<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SkExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function collection()
    {
        return $this->collection->map(function ($item) {
            return [
                'sk_number'   => $item->sk_number,
                'date'        => $item->date,
                'category' => $item->category->name,
                'description' => $item->description,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'SK Number',
            'Tanggal',
            'Category',
            'Description',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // Bold heading
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        // Border all cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A1:D{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 15,
            'C' => 12,
            'D' => 40,
        ];
    }
}
