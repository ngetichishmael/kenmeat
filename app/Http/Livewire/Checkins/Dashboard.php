<?php

namespace App\Http\Livewire\Checkins;

use Livewire\Component;
use App\Models\CheckIn;
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

    // Set default date range (e.g., today)
    if (!$this->startDate) {
        $this->startDate = now()->format('Y-m-d');
    }
    
    if (!$this->endDate) {
        $this->endDate = now()->format('Y-m-d');
    }

    $checkins = CheckIn::where(function ($query) use ($search) {
        $query->where('name', 'like', $search)
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
    });

    // Add date range filter
    if ($this->startDate && $this->endDate) {
        $checkins->whereBetween('time', [$this->startDate, $this->endDate]);
    }

    $checkins = $checkins->paginate($this->perPage); // Paginate the result

    return view('livewire.checkins.dashboard', compact('checkins'));
}

      
      
      
      
}
