<?php

namespace App\Exports;

use App\Models\customer\customers;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromView, WithMapping
{
    public function map($customer): array
    {
        return [
            $customer->customer_name,
            $customer->phone_number,
            $customer->address,
            // Add more fields as needed
        ];
    }

    protected $timeInterval;

    public function __construct($timeInterval = null)
    {
        $this->timeInterval = $timeInterval;
    }
    

    public function view(): View
    {
        $query = customers::orderBy('id', 'DESC');

        if ($this->timeInterval === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($this->timeInterval === 'yesterday') {
            $query->whereDate('created_at', today()->subDay());
        } elseif ($this->timeInterval === 'this_week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($this->timeInterval === 'this_month') {
            $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
        } elseif ($this->timeInterval === 'this_year') {
            $query->whereYear('created_at', now()->year);
        }

        $customers = $query->get();

        return view('Exports.customers', [
            'customers' => $customers,
        ]);
    }

}
