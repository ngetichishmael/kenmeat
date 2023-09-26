<?php

namespace App\Http\Livewire\Warehousing;

use App\Models\Region;
use App\Models\warehousing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\View;
use App\Exports\WarehousesExport;
use PDF;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $search = null;
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
        $warehouses = warehousing::with('region', 'subregion')->withCount('productInformation')
            ->when($this->user->account_type === "Managers", function ($query) {
                $query->whereIn('region_id', $this->filter());
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', $searchTerm);
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return view('livewire.warehousing.index', [
            'warehouses' => $warehouses,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function exportPDF()
    {
        $warehouses = warehousing::with('region', 'subregion')
            ->withCount('productInformation')
            ->when($this->user->account_type === 'Managers', function ($query) {
                $query->whereIn('region_id', $this->filter());
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();
    
        $pdf = PDF::loadView('Exports.warehousing.pdf_export', ['warehouses' => $warehouses]);
    
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Warehouses.pdf');
    }

    public function export()
    {
        return Excel::download(new WarehousesExport($this->orderBy, $this->orderAsc, $this->search), 'warehouses.xlsx');
    }

    public function filter(): array
    {

        $array = [];
        $user_code = $this->user->region_id;
        if (!$this->user->account_type === 'Managers') {
            return $array;
        }
        $regions = Region::where('id', $user_code)->pluck('id');
        if ($regions->isEmpty()) {
            return $array;
        }
        return $regions->toArray();
    }
}