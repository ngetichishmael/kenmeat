<?php

namespace App\Http\Livewire\Visits\Users;

use App\Exports\UserVisitsExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class View extends Component
{
    use WithPagination;
    public $start;
    public $end;
    public $user_code;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = null;
    public $username;
    public function render()
    {

        return view('livewire.visits.users.view', [
            'visits' => $this->data(),
        ]);
    }
    public function data()
    {
        $this->username = User::where('user_code', $this->user_code)->pluck('name')->implode('');

        $query = DB::table('users')
            ->join('customer_checkin', 'users.user_code', '=', 'customer_checkin.user_code')
            ->join('customers', 'customer_checkin.customer_id', '=', 'customers.id')
            ->where('users.user_code', $this->user_code)
            ->where('customers.customer_name', 'LIKE', '%' . $this->search . '%')
            ->whereRaw('customer_checkin.start_time <= customer_checkin.stop_time') // Condition to ensure start_time <= stop_time
            ->select(
                'users.name as name',
                'customers.customer_name AS customer_name',
                'customer_checkin.start_time AS start_time',
                'customer_checkin.stop_time AS stop_time',
                DB::raw("DATE_FORMAT(customer_checkin.updated_at, '%d/%m/%Y') as formatted_date"),
                DB::raw("SEC_TO_TIME(ABS(TIME_TO_SEC(TIMEDIFF(customer_checkin.stop_time, customer_checkin.start_time)))) AS duration")
            )
            ->orderBy('customer_checkin.updated_at', 'DESC'); // Order by the updated_at column in descending order

        if ($this->start != null) {
            // If end date is null, set it to the end of the current month
            $this->end = $this->end ?? Carbon::now()->endOfMonth()->format('Y-m-d');

            if (Carbon::parse($this->start)->isSameDay(Carbon::parse($this->end))) {
                $query->where('customer_checkin.updated_at', 'LIKE', "%" . $this->start . "%");
            } else {
                $query->whereBetween('customer_checkin.updated_at', [$this->start, $this->end]);
            }
        }

        $visits = $query->paginate($this->perPage);
        return $visits;
    }

    public function export()
    {
        return Excel::download(new UserVisitsExport($this->data()), $this->username . 'visits.xlsx');
    }
}
