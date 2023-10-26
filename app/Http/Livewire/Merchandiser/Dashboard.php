<?php

namespace App\Http\Livewire\Merchandiser;

use Livewire\Component;
use App\Models\MerchandiserReport;
use App\Models\customers; // Import the Customer model
use Livewire\WithPagination;
use Auth;
use Carbon\Carbon;

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
        $search = '%' . $this->search . '%';
    
        $reports = MerchandiserReport::with(['user', 'user.customer']) // Eager load the relationships
            ->where(function ($query) use ($search) {
                $query->where('user_id', 'like', $search)
                    ->orWhere('created_at', 'like', $search); // Search in customers.name
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage); // Use paginate method to enable pagination
    
        return view('livewire.merchandiser.dashboard', compact('reports'));
    }

// Add these properties and methods to your Livewire component

public $selectedReportId = null;
public $isDropdownOpen = false;

public function openDropdown($reportId)
{
    $this->selectedReportId = $reportId;
    $this->isDropdownOpen = true;
}

public function closeDropdown()
{
    $this->isDropdownOpen = false;
}

    
    
}
