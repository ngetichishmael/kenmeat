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
      public $orderBy = 'customer_checkin.id';
      public $orderAsc = false;
   

      public function render()
      {
          $search = '%' . $this->search . '%';
      
          $checkins = CheckIn::where(function ($query) use ($search) {
                  $query->where('name', 'like', $search)
                      ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                      ->paginate($this->perPage);
              })
              ->with('user') // Load the related user model
              ->get(); // Retrieve the results
      
          return view('livewire.checkins.dashboard', compact('checkins'));
      }
      
}
