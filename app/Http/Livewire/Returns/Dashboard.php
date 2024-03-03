<?php

namespace App\Http\Livewire\Returns;

use Livewire\Component;
use App\Models\Returnable;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search;
    public $orderBy = 'id';
    public $orderAsc = false;
    public $startDate;
    public $endDate;

    public function render()
    {
        $searchTerm = '%' . $this->search . '%';

        // Retrieve the latest returnable for each customer
        $latestReturns = Returnable::with('product','customer')
            ->where('status', 'like', $searchTerm)
            ->orderBy('created_at', 'desc')
            ->groupBy('customer_id') // Group by customer_id
            ->latest() // Get the latest returnable for each customer
            ->paginate($this->perPage);

        return view('livewire.returns.dashboard', ['returns' => $latestReturns]);
    }
}
