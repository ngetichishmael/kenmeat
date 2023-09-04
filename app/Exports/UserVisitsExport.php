<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UserVisitsExport implements FromCollection, WithHeadings
{

   protected $data;

   public function __construct(Collection $data)
   {
       $this->data = $data;
   }

   public function collection()
   {
       return $this->data;
   }

   public function headings(): array
   {
       // The column headings are already provided in the data collection,
       // so there's no need to return headings separately here.
       return [];
   }
}
