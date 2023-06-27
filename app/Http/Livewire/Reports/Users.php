<?php

namespace App\Http\Livewire\Reports;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Users extends Component
{
    public function render()
    {
        $usercount = User::whereNotNull('user_code')->select('account_type', DB::raw('COUNT(*) as count'))
         ->groupBy('account_type')
         ->get();
        return view('livewire.reports.users', ['usercount' => $usercount]);
    }
}
