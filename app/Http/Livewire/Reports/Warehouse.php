<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\warehousing;
use Livewire\WithPagination;
use App\Exports\WarehouseExport;
use Maatwebsite\Excel\Facades\Excel;

class Warehouse extends Component
{
    protected $paginationTheme = 'bootstrap';
   public $start;
   public $end;
   use WithPagination;
    public function render()
    {   
        $count = 1;
        return view('livewire.reports.warehouse', [
            'warehouses' => $this->data(),
            'count' => $count
        ]);
    }
    public function data()
   {
      $query = warehousing::whereNotNull('warehouse_code')->get();
      if (!is_null($this->start)) {
         if (Carbon::parse($this->start)->equalTo(Carbon::parse($this->end))) {
            $query->whereDate('created_at', 'LIKE', "%" . $this->start . "%");
         } else {
            if (is_null($this->end)) {
               $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
            }
            $query->whereBetween('created_at', [$this->start, $this->end]);
         }
      }

      return $query;
   }
//     public function export()
//    {
//       return Excel::download(new WarehouseExport, 'warehouses.xlsx');
//    }
}
