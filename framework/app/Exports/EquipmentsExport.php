<?php

namespace App\Exports;

use App\Equipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquipmentsExport implements FromCollection, WithHeadings
{

    public function __construct($equipments)
    {
        $this->equipments = $equipments;
    }

    public function collection()
    {
        // $xequipment = collect($this->equipments->latest()->get());
        return $this->equipments;
    }

    public function headings(): array
    {

        $headings = new Equipment;
        $headings = $headings->getTableColumns();

        foreach ($headings as $heading) {
            $array[] = $heading;
        }

        return $array;
    }
}