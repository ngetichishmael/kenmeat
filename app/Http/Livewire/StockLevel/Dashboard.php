<?php

namespace App\Http\Livewire\StockLevel;

use Livewire\Component;
use App\Models\SalesStockLevel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Dashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $search = '';

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        $stockLevels = SalesStockLevel::with('user','customer')
            ->where('stock_level', 'like', $searchTerm)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.stock-level.dashboard', ['stockLevels' => $stockLevels]);
    }
}
