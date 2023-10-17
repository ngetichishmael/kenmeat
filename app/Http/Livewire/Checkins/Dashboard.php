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
      
          $checkins = CheckIn::where(function ($query) use ($search) {
              $query->where('name', 'like', $search);
          });
      
          // Check if the date range filter is provided
          if ($this->startDate && $this->endDate) {
              $checkins->whereBetween('time', [$this->startDate, $this->endDate]);
          } else {
              // If no date range is provided, default to daily check-ins
              $checkins->whereDate('time', now());
          }
      
          // Order the check-ins by time in descending order (most recent first)
          $checkins->orderBy('time', 'desc');
      
          $checkins = $checkins->paginate($this->perPage);
      
          return view('livewire.checkins.dashboard', compact('checkins'));
      }
      
      
      
      
      
      
}
