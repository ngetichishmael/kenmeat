<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Returnable;
use App\Models\customers;


class ReturnsController extends Controller
{
    public function index()
    {
       return view('livewire.returns.layout');
    }

    public function show($customerId)
    {
        $customer = customers::find($customerId);
        $returnedProducts = $customer->returnedProducts; 

        return view('returned-products.index', compact('returnedProducts', 'customer'));
    }

    // public function viewCustomerReturns($customerId)
    // {
    //     $customer = Returnable::with('product')->where('customer_id', $customerId)->get();

    //     return view('livewire.returns.show', ['customer' => $customer]);
    // }

    public function viewCustomerReturns($customerId)
    {
        $customer = customers::find($customerId);
        $returns = Returnable::with('product')->where('customer_id', $customerId)->get();

        return view('livewire.returns.show', compact('customer', 'returns'));
    }


}
