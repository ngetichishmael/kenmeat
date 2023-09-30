<?php

namespace App\Http\Livewire\Target;

use App\Models\User;
use App\Models\VisitsTarget;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;


class Visit extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 15;
   public $search = '';
   public $timeFrame = 'quarter';

   public function render()
   {

    // Create a query for the 'visit_targets' table
    $targetsQuery = VisitsTarget::query()->with('User');
    $today = Carbon::now();
    
    // Calculate the start and end dates of the current month
    $currentMonthStart = Carbon::now()->startOfMonth();
    $currentMonthEnd = Carbon::now()->endOfMonth();
    
    // Apply search filter
    if (!empty($this->search)) {
        $targetsQuery->whereHas('User', function ($query) {
            $query->where('name', 'LIKE', '%' . $this->search . '%');
        });
    }
    
    // Apply time frame filter to only include targets within the current month
    $targetsQuery->whereBetween('Deadline', [$currentMonthStart, $currentMonthEnd]);
    
    // Fetch targets with pagination based on $this->perPage
    $targets = $targetsQuery->paginate($this->perPage);

      return view('livewire.target.visit', [
         'targets' => $targets,
         'today' => $today,
      ]);
   }

   private function applyTimeFrameFilter($query)
   {
      $endDate = Carbon::now();

      // Set end date based on selected time frame
      if ($this->timeFrame === 'quarter') {
         $endDate->endOfQuarter();
      } elseif ($this->timeFrame === 'half_year') {
         $endMonth = $endDate->month <= 6 ? 6 : 12;
         $endDate->setMonth($endMonth)->endOfMonth();
      } elseif ($this->timeFrame === 'year') {
         $endDate->endOfYear();
      }

      // Apply the filter
      $query->whereHas('TargetVisit', function ($targetSaleQuery) use ($endDate) {
         $targetSaleQuery->whereDate('Deadline', '<=', $endDate->format('Y-m-d'));
      });
   }
   public function getSuccessRatio($achieved, $target)
   {
      if ($target != 0) {
         return number_format(($achieved / $target) * 100, 2);
      }

      return 0;
   }
}
