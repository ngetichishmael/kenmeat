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
   

      public function render()
      {
          $search = '%' . $this->search . '%';
      
          $checkins = CheckIn::where(function ($query) use ($search) {
              $query->where('name', 'like', $search)
                  ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
          })->paginate($this->perPage); 

          
      
          return view('livewire.checkins.dashboard', compact('checkins'));
      }
      
      
}
