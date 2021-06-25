<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class JustExcelExport implements FromArray,WithHeadings,ShouldAutoSize
{
    protected $invoices;
    protected $headings;

    public function __construct(array $invoices, array $headings)
    {
        $this->invoices = $invoices;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        return $this->headings;
    }

}


















