<?php

namespace App\Http\Livewire\StockLevel;

use Livewire\Component;
use App\Models\SalesStockLevel;
use App\Models\FormResponse;

use Livewire\WithPagination;

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

        $stockLevels = FormResponse::with('user', 'customer', 'availableProducts')
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', $searchTerm);
                })
                ->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('customer_name', 'like', $searchTerm);
                });
            })
            ->whereHas('availableProducts') 
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.stock-level.dashboard', ['stockLevels' => $stockLevels]);
    }
}
