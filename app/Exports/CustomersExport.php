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

    public function view(): View
    {
        $customers = customers::orderBy('id', 'DESC')->get();

        return view('Exports.customers', [
            'customers' => $customers,
        ]);
    }
}
