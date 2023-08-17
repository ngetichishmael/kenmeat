<?php

namespace App\Http\Livewire\Warehousing;

use App\Models\Region;
use Livewire\Component;
use App\Models\customers;
use App\Models\warehousing;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PDF;
use App\Exports\WarehousesExport;
use Excel;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public ?string $search = null;
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        $warehouses = warehousing::with('manager', 'region', 'subregion')
            ->withCount('productInformation')
            ->when($this->user->account_type === "RSM", function ($query) use ($searchTerm) {
                $query->whereIn('region_id', $this->filter())
                    ->where(function (Builder $query) use ($searchTerm) {
                        $query->where('Region.name', 'like', $searchTerm)
                            ->orWhere('name', 'like', $searchTerm);
                    });
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPage);

        $pdfData = [
            'warehouses' => $warehouses,
        ];

        return view('livewire.warehousing.index', $pdfData);
    }

    public function exportPDF()
    {
        $pdfData = [
            'warehouses' => warehousing::with('manager', 'region', 'subregion')
                ->withCount('productInformation')
                ->when($this->user->account_type === "RSM", function ($query) {
                    $query->whereIn('region_id', $this->filter());
                })
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->get(),
        ];

        $pdf = PDF::loadView('Exports.warehouse_pdf', $pdfData);

        // Add the following response headers
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'warehouses.pdf');
    }

    public function export()
    {
        return Excel::download(new WarehousesExport, 'warehouses.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new WarehousesExport, 'warehouses.csv');
    }
}
