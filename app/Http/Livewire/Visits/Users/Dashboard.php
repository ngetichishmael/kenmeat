<?php

namespace App\Http\Livewire\Visits\Users;

use App\Exports\UsersVisitsExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
    use WithPagination;

    public $start;
    public $end;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = null;
    public $selectedDate;
    public $selectedMonth;

    public function mount()
    {
        $this->selectedDate = Carbon::now()->format('Y-m-d');
        $this->selectedMonth = Carbon::now()->format('Y-m');
    }

    public function render()
    {
        return view('livewire.visits.users.dashboard', [
            'visits' => $this->data(),
        ]);
    }

    public function data()
    {

        $searchTerm = '%' . $this->search . '%';
        $query = User::leftJoin('customer_checkin', function ($join) {
            $join->on('users.user_code', '=', 'customer_checkin.user_code')
                ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time');
        })
            ->select(
                'users.name as name',
                'users.user_code as user_code',
                DB::raw('SUM(IF(DATE(customer_checkin.updated_at) = DATE("' . $this->selectedDate . '"), 1, 0)) as today_count'),
                DB::raw('COUNT(customer_checkin.id) as visit_count'),
                DB::raw('SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time)))) as average_time'),
                DB::raw('MAX(customer_checkin.created_at) as last_visit_date') // Use created_at for the last visit date
            )
            ->where('users.name', 'like', $searchTerm)
            ->groupBy('users.name', 'users.user_code')
            ->havingRaw('visit_count > 0'); // Only include users with completed visits
    
        if ($this->selectedMonth != null) {
            $query->whereYear('customer_checkin.created_at', '=', Carbon::parse($this->selectedMonth)->format('Y'))
                ->whereMonth('customer_checkin.created_at', '=', Carbon::parse($this->selectedMonth)->format('m'));
        } else {
            if ($this->start != null && $this->end != null) {
                $query->whereBetween('customer_checkin.start_time', [$this->start, $this->end]);
            } else {
                $query->whereDate('customer_checkin.updated_at', '=', $this->selectedDate);
            }
        }
    
        // Order by created_at in descending order to get the latest visit as the first record
        $query->orderByDesc('customer_checkin.created_at');
    
        $visits = $query->paginate($this->perPage);
    
        // Set the last_visit_time for each user based on the first record's created_at
        foreach ($visits as $visit) {
            $visit->last_visit_time = \Carbon\Carbon::parse($visit->last_visit_date)->format('Y-m-d H:i:s');
        }
    
    

        return $visits;
    }

    public function updatedStart()
    {
        // Clear the selectedMonth when the Date filter changes
        $this->selectedMonth = null;
        $this->render();
    }

    public function updatedEnd()
    {
        // Clear the selectedMonth when the Date filter changes
        $this->selectedMonth = null;
        $this->render();
    }

    public function export()
    {
        return Excel::download(new UsersVisitsExport($this->data()), 'visits.xlsx');
    }
}
