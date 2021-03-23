<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserUploadExcelExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{

    use Exportable;

	private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
	public function title(): string
    {
        return 'Data Upload';
    }
    public function collection()
    {
        return collect($this->data);
    }
	public function styles(Worksheet $sheet)
    {
        return [
            // Styling a specific cell by coordinate.
            'A1:W1' => ['font' => ['size' => 16]],
           // 'A1:W1' => ['font' => ['bold' => true]],
        ];
    }
    public function headings(): array
    {
        return [
            'Firstname',
			'Lastname',
			'Subject Property Address',
			'Unit Number',
			'City',
			'State',
			'Zip',
			'APN-Subject Property',
			'Mailing Address',
			'Mailing Unit Number',
			'Mailing City',
			'Mailing State',
			'Mailing Zip',
			'Phone',
			'Email',
        ];
    }

}