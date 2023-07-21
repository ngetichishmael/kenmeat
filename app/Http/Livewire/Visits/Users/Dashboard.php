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

    public function render()
    {
        return view('livewire.visits.users.dashboard', [
            'visits' => $this->data(),
        ]);
    }

    public function data()
{
    $searchTerm = '%' . $this->search . '%';
    $query = User::join('customer_checkin', 'users.user_code', '=', 'customer_checkin.user_code')
        ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time')
        ->select(
            'users.name as name',
            'users.user_code as user_code',
            DB::raw('COUNT(customer_checkin.id) as visit_count'),
            DB::raw('SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time)))) as average_time'),
            DB::raw('MAX(customer_checkin.start_time) as last_visit_time')
        )
        ->where('users.name', 'like', $searchTerm)
        ->groupBy('users.name');

    if ($this->start != null) {
        // If end date is null, set it to the end of the current day
        $this->end = $this->end ?? Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        // Filter by the selected start and end dates (considering both date and time)
        $query->whereBetween('customer_checkin.start_time', [$this->start . ' 00:00:00', $this->end . ' 23:59:59']);
    } else {
        // If start date is not provided, filter by today's date (considering both date and time)
        $today = Carbon::today()->format('Y-m-d');
        $query->whereBetween('customer_checkin.start_time', [$today . ' 00:00:00', $today . ' 23:59:59']);
    }

    $visits = $query->paginate($this->perPage);
    return $visits;
}


    public function updatedStart()
    {
        $this->render();
    }

    public function updatedEnd()
    {
        $this->render();
    }

    public function export()
    {
        return Excel::download(new UsersVisitsExport($this->data()), 'visits.xlsx');
    }
}
