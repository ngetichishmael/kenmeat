<?php

namespace App\Http\Livewire\Visits\Customer;

use App\Exports\CustomersExport;
use App\Exports\CustomerVisitExport;
use App\Models\customer\checkin;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public ?string $search = null;
   public ?string $start = null;
   public ?string $end = null;

   public $submenuItemSelected = false; // Track submenu selection
   public $selectedExportType = null;
   public $selectedInterval = null;
   public function render()
   {
       return view('livewire.visits.customer.dashboard', [
           'visits' => $this->getCustomerVisits(),
       ]);
   }

   public function export()
   {
      Log::info('Export method called ');
      Log::info('submenuItemSelected'.$this->selectedExportType);
      Log::info('selectedInterval'.$this->selectedInterval);
      if (!$this->selectedExportType || !$this->selectedInterval) {
         return;
      }
      Log::info("Export method called. Export type: {$this->selectedExportType}");
      if ($this->selectedExportType) {
         if ($this->selectedExportType === 'excel') {
            $this->emit('exportComplete');
            session()->flash('success', 'Export successful!');
            return Excel::download(new CustomerVisitExport($this->selectedInterval), 'Customers_checkins.xlsx');
         } elseif ($this->selectedExportType === 'csv') {
            $this->emit('exportComplete');
            session()->flash('success', 'Export successful!');
            return Excel::download(new CustomerVisitExport($this->selectedInterval), 'Customers_checkins.csv');
         } elseif ($this->selectedExportType === 'pdf') {

            $query = checkin::select('customer_checkin.*', 'users.name')
               ->join('users', 'customer_checkin.user_code', '=', 'users.user_code')
               ->orderBy('customer_checkin.user_code') // Order by user_code (users' codes) in ascending order
               ->orderBy('users.name'); // Order users' names in alphabetical order

            if ($this->selectedInterval === 'today') {
               $query->whereDate('customer_checkin.created_at', today());
            } elseif ($this->selectedInterval === 'yesterday') {
               $query->whereDate('customer_checkin.created_at', today()->subDay());
            } elseif ($this->selectedInterval === 'this_week') {
               $query->whereBetween('customer_checkin.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            } elseif ($this->selectedInterval === 'this_month') {
               $query->whereYear('customer_checkin.created_at', now()->year)->whereMonth('checkins.created_at', now()->month);
            } elseif ($this->selectedInterval === 'this_year') {
               $query->whereYear('customer_checkin.created_at', now()->year);
            }

            $checkin = $query->get();
            $data = [
               'visits' => $checkin,
            ];
            $pdf = PDF::loadView('Exports.customer_visits_pdf', $data);
            session()->flash('exportSuccessMessage', 'Export successful!');
            $this->emit('exportComplete');
            return response()->streamDownload(function () use ($pdf) {
               echo $pdf->output();
            }, 'Customers_checkins.pdf');
         }
      }else{
         session()->flash('error', 'Export successful!');
         return;
      }
   }

   public function setExportType($type)
   {
      $this->selectedExportType = $type;

      if ($type !== 'all') {
         $this->export();
      }
   }

//   public function export($timeInterval = null)
//   {
//       return Excel::download(new CustomerVisitExport($timeInterval), 'Customers_checkins.xlsx');
//   }

   public function exportCSV($timeInterval = null)
   {
      return Excel::download(new CustomerVisitExport($timeInterval), 'Customers_checkins.csv');
   }

   public function exportPDF($timeInterval = null)
   {
      $data = [
         'visits' => $this->getCustomerVisits(),
      ];

      $pdf = PDF::loadView('Exports.customer_visits_pdf', $data);

      // Add the following response headers
      return response()->streamDownload(function () use ($pdf) {
         echo $pdf->output();
      }, 'Customers_checkins.pdf');
   }

   private function getCustomerVisits()
   {
      $searchTerm = '%' . $this->search . '%';

      $query = checkin::with('User', 'Customer')
         ->whereLike(
            [
               'User.name',
               'Customer.customer_name'
            ],
            $searchTerm
         )
         ->orderBy('created_at', 'desc'); // Order the results by the most recent 'created_at' date

      // Apply start and end date filters if provided
      if ($this->start && $this->end) {
         $query->whereBetween('created_at', [$this->start, $this->end]);
      } elseif ($this->start) {
         $query->where('created_at', '>=', $this->start);
      } elseif ($this->end) {
         $query->where('created_at', '<=', $this->end);
      }
      //$visits = $query->paginate($this->perPage);
      return $query->paginate($this->perPage);

   }
}
