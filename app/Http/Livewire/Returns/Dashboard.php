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

        $returns = Returnable::with('product','customer')
            ->where('status', 'like', $searchTerm)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

            return view('livewire.returns.dashboard', ['returns' => $returns]);
        }
}
