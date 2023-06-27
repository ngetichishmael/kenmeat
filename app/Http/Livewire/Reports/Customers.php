<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class Customers extends Component
{
    protected $paginationTheme = 'bootstrap';
   public $start;
   public $end;
   use WithPagination;
    public function render()
    {
        return view('livewire.reports.customers');
    }

//     public function export()
//    {
//       return Excel::download(new CustomersExport, 'Customers.xlsx');
//    }
}
