<?php

namespace App\Http\Livewire\Stocks;

use App\Models\warehouse_assign;
use App\Models\warehousing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Reconciliation extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public ?string $search = null;
    public function render()
    {
        $searchTerm = '%' . $this->search . '%';
      $warehouses = warehousing::with( 'region', 'subregion','ReconciledProducts');
      //$warehouses = warehousing::with( 'region', 'subregion');

//         ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
       if ((strcasecmp(Auth::user()->account_type, 'Account Manager') == 0)) {

          $warehouses = $warehouses->where('region_id', Auth::user()->region_id)
             ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
             ->paginate($this->perPage);

       }else{

          $warehouses = $warehouses->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
             ->paginate($this->perPage);
       }

        return view('livewire.stocks.reconciliation',['warehouses' => $warehouses]);
    }
}
